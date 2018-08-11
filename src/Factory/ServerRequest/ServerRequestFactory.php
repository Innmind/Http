<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\ServerRequest;

use Innmind\Http\{
    Factory\ServerRequestFactory as ServerRequestFactoryInterface,
    Message\ServerRequest,
    Message\Method\Method,
    ProtocolVersion\ProtocolVersion,
    Factory\HeadersFactory,
    Factory\Header\Factories,
    Factory\EnvironmentFactory,
    Factory\CookiesFactory,
    Factory\QueryFactory,
    Factory\FormFactory,
    Factory\FilesFactory,
    Factory
};
use Innmind\Url\Url;
use Innmind\Filesystem\Stream\LazyStream;
use Innmind\Immutable\{
    Str,
    Map
};

final class ServerRequestFactory implements ServerRequestFactoryInterface
{
    private $headersFactory;
    private $environmentFactory;
    private $cookiesFactory;
    private $queryFactory;
    private $formFactory;
    private $filesFactory;

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

    public function make(): ServerRequest
    {
        $protocol = (new Str($_SERVER['SERVER_PROTOCOL']))->capture(
            '~HTTP/(?<major>\d)\.(?<minor>\d)~'
        );
        $https = (string) Str::of($_SERVER['HTTPS'] ?? 'off')->toLower();

        return new ServerRequest\ServerRequest(
            Url::fromString(sprintf(
                '%s://%s%s',
                $https === 'on' ? 'https' : 'http',
                $_SERVER['HTTP_HOST'],
                $_SERVER['REQUEST_URI']
            )),
            new Method($_SERVER['REQUEST_METHOD']),
            new ProtocolVersion(
                (int) (string) $protocol['major'],
                (int) (string) $protocol['minor']
            ),
            $this->headersFactory->make(),
            new LazyStream('php://input'),
            $this->environmentFactory->make(),
            $this->cookiesFactory->make(),
            $this->queryFactory->make(),
            $this->formFactory->make(),
            $this->filesFactory->make()
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
                Factories::default()
            ),
            new Factory\Environment\EnvironmentFactory,
            new Factory\Cookies\CookiesFactory,
            new Factory\Query\QueryFactory,
            new Factory\Form\FormFactory,
            new Factory\Files\FilesFactory
        );
    }
}
