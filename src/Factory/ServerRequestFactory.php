<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory;

use Innmind\Http\{
    ServerRequest,
    Method,
    ProtocolVersion,
    Factory,
};
use Innmind\TimeContinuum\Clock;
use Innmind\Filesystem\File\Content;
use Innmind\Url\Url;
use Innmind\IO\IO;
use Innmind\Immutable\{
    Str,
    Maybe,
};

/**
 * @psalm-immutable
 */
final class ServerRequestFactory
{
    /**
     * @param \Closure(): Content $bodyFactory
     * @param array<string, string> $server
     */
    private function __construct(
        private HeadersFactory $headersFactory,
        private \Closure $bodyFactory,
        private EnvironmentFactory $environmentFactory,
        private CookiesFactory $cookiesFactory,
        private QueryFactory $queryFactory,
        private FormFactory $formFactory,
        private FilesFactory $filesFactory,
        private array $server,
    ) {
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

        /**
         * @psalm-suppress ImpureFunctionCall
         */
        return ServerRequest::of(
            Url::of(\sprintf(
                '%s://%s%s%s',
                $https === 'on' ? 'https' : 'http',
                $user,
                $this->server['HTTP_HOST'],
                $this->server['REQUEST_URI'],
            )),
            Method::of($this->server['REQUEST_METHOD']),
            Maybe::all($protocol->get('major'), $protocol->get('minor'))
                ->flatMap(static fn(Str $major, Str $minor) => ProtocolVersion::maybe(
                    (int) $major->toString(),
                    (int) $minor->toString(),
                ))
                ->match(
                    static fn($protocol) => $protocol,
                    static fn() => ProtocolVersion::v11,
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
    public static function default(
        Clock $clock,
        ?IO $io = null,
    ): self {
        $io ??= IO::fromAmbientAuthority();
        /** @var array<string, string> */
        $server = $_SERVER;

        /** @psalm-suppress PossiblyFalseArgument */
        return new self(
            HeadersFactory::default($clock),
            static fn() => Content::oneShot(
                $io
                    ->streams()
                    ->acquire(\fopen('php://input', 'r')),
            ),
            EnvironmentFactory::default(),
            CookiesFactory::default(),
            QueryFactory::default(),
            FormFactory::default(),
            FilesFactory::default($io),
            $server,
        );
    }

    /**
     * @psalm-pure
     *
     * @param \Closure(): Content $bodyFactory
     * @param array<string, string> $server
     */
    public static function of(
        HeadersFactory $headersFactory,
        \Closure $bodyFactory,
        EnvironmentFactory $environmentFactory,
        CookiesFactory $cookiesFactory,
        QueryFactory $queryFactory,
        FormFactory $formFactory,
        FilesFactory $filesFactory,
        array $server,
    ): self {
        return new self(
            $headersFactory,
            $bodyFactory,
            $environmentFactory,
            $cookiesFactory,
            $queryFactory,
            $formFactory,
            $filesFactory,
            $server,
        );
    }
}
