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
use Innmind\TimeContinuum\Clock;
use Innmind\Url\Url;
use Innmind\Stream\Readable\Stream;
use Innmind\Immutable\{
    Str,
    Maybe,
};

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
            Method::of($_SERVER['REQUEST_METHOD']),
            Maybe::all($protocol->get('major'), $protocol->get('minor'))
                ->map(static fn(Str $major, Str $minor) => new ProtocolVersion(
                    (int) $major->toString(),
                    (int) $minor->toString(),
                ))
                ->match(
                    static fn($protocol) => $protocol,
                    static fn() => new ProtocolVersion(1, 1),
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
     */
    public static function default(Clock $clock): self
    {
        return new self(
            Factory\Header\HeadersFactory::default(
                Factories::default($clock),
            ),
            new Factory\Environment\EnvironmentFactory,
            Factory\Cookies\CookiesFactory::default(),
            new Factory\Query\QueryFactory,
            new Factory\Form\FormFactory,
            new Factory\Files\FilesFactory,
        );
    }
}
