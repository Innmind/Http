<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory;

use Innmind\Http\{
    Message\ServerRequestInterface,
    Message\ServerRequest,
    Message\Method,
    ProtocolVersion
};
use Innmind\Url\Url;
use Innmind\Filesystem\Stream\Stream;
use Innmind\Immutable\StringPrimitive as Str;

final class ServerRequestFactory implements ServerRequestFactoryInterface
{
    private $headersFactory;
    private $environmentFactory;
    private $cookiesFactory;
    private $queryFactory;
    private $formFactory;
    private $filesFactory;

    public function __construct(
        HeadersFactoryInterface $headersFactory,
        EnvironmentFactoryInterface $environmentFactory,
        CookiesFactoryInterface $cookiesFactory,
        QueryFactoryInterface $queryFactory,
        FormFactoryInterface $formFactory,
        FilesFactoryInterface $filesFactory
    ) {
        $this->headersFactory = $headersFactory;
        $this->environmentFactory = $environmentFactory;
        $this->cookiesFactory = $cookiesFactory;
        $this->queryFactory = $queryFactory;
        $this->formFactory = $formFactory;
        $this->filesFactory = $filesFactory;
    }

    public function make(): ServerRequestInterface
    {
        $protocol = (new Str($_SERVER['SERVER_PROTOCOL']))->getMatches(
            '~HTTP/(?<major>\d)\.(?<minor>\d)~'
        );

        return new ServerRequest(
            Url::fromString(
                $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']
            ),
            new Method($_SERVER['REQUEST_METHOD']),
            new ProtocolVersion(
                (int) (string) $protocol['major'],
                (int) (string) $protocol['minor']
            ),
            $this->headersFactory->make(),
            new Stream(fopen('php://input', 'r')),
            $this->environmentFactory->make(),
            $this->cookiesFactory->make(),
            $this->queryFactory->make(),
            $this->formFactory->make(),
            $this->filesFactory->make()
        );
    }
}
