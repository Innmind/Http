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
use Innmind\Filesystem\File\Content;
use Innmind\Url\Url;
use Innmind\Stream\Readable;
use Innmind\Immutable\{
    Str,
    Maybe,
};

/**
 * @psalm-immutable
 */
final class ServerRequestFactory implements ServerRequestFactoryInterface
{
    private HeadersFactory $headersFactory;
    /** @var callable(): Content */
    private $bodyFactory;
    private EnvironmentFactory $environmentFactory;
    private CookiesFactory $cookiesFactory;
    private QueryFactory $queryFactory;
    private FormFactory $formFactory;
    private FilesFactory $filesFactory;
    /** @var array<string, string> */
    private array $server;

    /**
     * @param callable(): Content $bodyFactory
     * @param array<string, string> $server
     */
    public function __construct(
        HeadersFactory $headersFactory,
        callable $bodyFactory,
        EnvironmentFactory $environmentFactory,
        CookiesFactory $cookiesFactory,
        QueryFactory $queryFactory,
        FormFactory $formFactory,
        FilesFactory $filesFactory,
        array $server,
    ) {
        $this->headersFactory = $headersFactory;
        $this->bodyFactory = $bodyFactory;
        $this->environmentFactory = $environmentFactory;
        $this->cookiesFactory = $cookiesFactory;
        $this->queryFactory = $queryFactory;
        $this->formFactory = $formFactory;
        $this->filesFactory = $filesFactory;
        $this->server = $server;
    }

    public function __invoke(): ServerRequest
    {
        /** @psalm-suppress MixedArgument */
        $protocol = Str::of($this->server['SERVER_PROTOCOL'])->capture(
            '~HTTP/(?<major>\d)\.(?<minor>\d)~',
        );
        /** @psalm-suppress RedundantCastGivenDocblockType */
        $https = Str::of((string) ($this->server['HTTPS'] ?? 'off'))->toLower()->toString();
        $user = '';

        if (isset($this->server['PHP_AUTH_USER'])) {
            $user = $this->server['PHP_AUTH_USER'];

            if (isset($this->server['PHP_AUTH_PW'])) {
                /** @psalm-suppress MixedOperand */
                $user .= ':'.$this->server['PHP_AUTH_PW'];
            }

            $user .= '@';
        }

        /** @psalm-suppress MixedArgument */
        return new ServerRequest\ServerRequest(
            Url::of(\sprintf(
                '%s://%s%s%s',
                $https === 'on' ? 'https' : 'http',
                $user,
                $this->server['HTTP_HOST'],
                $this->server['REQUEST_URI'],
            )),
            Method::of($this->server['REQUEST_METHOD']),
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
            ($this->bodyFactory)(),
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
        /** @var array<string, string> */
        $server = $_SERVER;

        return new self(
            Factory\Header\HeadersFactory::default(
                Factories::default($clock),
            ),
            static fn() => Content\OfStream::of(
                new Readable\Stream(\fopen('php://input', 'r')),
            ),
            Factory\Environment\EnvironmentFactory::default(),
            Factory\Cookies\CookiesFactory::default(),
            Factory\Query\QueryFactory::default(),
            Factory\Form\FormFactory::default(),
            Factory\Files\FilesFactory::default(),
            $server,
        );
    }
}
