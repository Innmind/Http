<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\ServerRequest;

use Innmind\Http\{
    Factory\ServerRequestFactory as ServerRequestFactoryInterface,
    Message\ServerRequest,
    Message\Method,
    ProtocolVersion,
    Factory\HeadersFactory,
    Factory\Header\Factories,
    Factory\EnvironmentFactory,
    Factory\CookiesFactory,
    Factory\QueryFactory,
    Factory\FormFactory,
    Factory\FilesFactory,
    Factory,
};
use Innmind\Url\Url;
use Innmind\Stream\Readable\Stream;
use Innmind\Immutable\Str;

final class ServerRequestFactory implements ServerRequestFactoryInterface
{
    private HeadersFactory $headersFactory;
    private EnvironmentFactory $environmentFactory;
    private CookiesFactory $cookiesFactory;
    private QueryFactory $queryFactory;
    private FormFactory $formFactory;
    private FilesFactory $filesFactory;

    public function __construct(
        HeadersFactory $headersFactory,
        EnvironmentFactory $environmentFactory,
        CookiesFactory $cookiesFactory,
        QueryFactory $queryFactory,
        FormFactory $formFactory,
        FilesFactory $filesFactory
    ) {
        $this->headersFactory = $headersFactory;
        $this->environmentFactory = $environmentFactory;
        $this->cookiesFactory = $cookiesFactory;
        $this->queryFactory = $queryFactory;
        $this->formFactory = $formFactory;
        $this->filesFactory = $filesFactory;
    }

    public function __invoke(): ServerRequest
    {
        /** @psalm-suppress MixedArgument */
        $protocol = Str::of($_SERVER['SERVER_PROTOCOL'])->capture(
            '~HTTP/(?<major>\d)\.(?<minor>\d)~',
        );
        $https = Str::of((string) ($_SERVER['HTTPS'] ?? 'off'))->toLower()->toString();
        $user = '';

        if (isset($_SERVER['PHP_AUTH_USER'])) {
            /** @var string */
            $user = $_SERVER['PHP_AUTH_USER'];

            if (isset($_SERVER['PHP_AUTH_PW'])) {
                /** @psalm-suppress MixedOperand */
                $user .= ':'.$_SERVER['PHP_AUTH_PW'];
            }

            $user .= '@';
        }


        /** @psalm-suppress MixedArgument */
        return new ServerRequest\ServerRequest(
            Url::of(\sprintf(
                '%s://%s%s%s',
                $https === 'on' ? 'https' : 'http',
                $user,
                $_SERVER['HTTP_HOST'],
                $_SERVER['REQUEST_URI'],
            )),
            new Method($_SERVER['REQUEST_METHOD']),
            new ProtocolVersion(
                (int) $protocol->get('major')->toString(),
                (int) $protocol->get('minor')->toString(),
            ),
            ($this->headersFactory)(),
            new Stream(\fopen('php://input', 'r')),
            ($this->environmentFactory)(),
            ($this->cookiesFactory)(),
            ($this->queryFactory)(),
            ($this->formFactory)(),
            ($this->filesFactory)(),
        );
    }

    /**
     * Return a fully configured factory
     *
     * @return self
     */
    public static function default(): self
    {
        return new self(
            new Factory\Header\HeadersFactory(
                Factories::default(),
            ),
            new Factory\Environment\EnvironmentFactory,
            new Factory\Cookies\CookiesFactory,
            new Factory\Query\QueryFactory,
            new Factory\Form\FormFactory,
            new Factory\Files\FilesFactory,
        );
    }
}
