<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Message;

use Innmind\Http\{
    MessageInterface,
    ProtocolVersionInterface,
    HeadersInterface,
    Message\ServerRequest,
    Message\RequestInterface,
    Message\ServerRequestInterface,
    Message\MethodInterface,
    Message\EnvironmentInterface,
    Message\CookiesInterface,
    Message\QueryInterface,
    Message\FormInterface,
    Message\FilesInterface
};
use Innmind\Url\UrlInterface;
use Innmind\Filesystem\StreamInterface;
use PHPUnit\Framework\TestCase;

class ServerRequestTest extends TestCase
{
    public function testInterface()
    {
        $r = new ServerRequest(
            $url = $this->createMock(UrlInterface::class),
            $method = $this->createMock(MethodInterface::class),
            $protocol = $this->createMock(ProtocolVersionInterface::class),
            $headers = $this->createMock(HeadersInterface::class),
            $body = $this->createMock(StreamInterface::class),
            $env = $this->createMock(EnvironmentInterface::class),
            $cookies = $this->createMock(CookiesInterface::class),
            $query = $this->createMock(QueryInterface::class),
            $form = $this->createMock(FormInterface::class),
            $files = $this->createMock(FilesInterface::class)
        );

        $this->assertInstanceOf(MessageInterface::class, $r);
        $this->assertInstanceOf(RequestInterface::class, $r);
        $this->assertInstanceOf(ServerRequestInterface::class, $r);
        $this->assertSame($url, $r->url());
        $this->assertSame($method, $r->method());
        $this->assertSame($protocol, $r->protocolVersion());
        $this->assertSame($headers, $r->headers());
        $this->assertSame($body, $r->body());
        $this->assertSame($env, $r->environment());
        $this->assertSame($cookies, $r->cookies());
        $this->assertSame($query, $r->query());
        $this->assertSame($form, $r->form());
        $this->assertSame($files, $r->files());
    }

    public function testDefaultValues()
    {
        $request = new ServerRequest(
            $this->createMock(UrlInterface::class),
            $this->createMock(MethodInterface::class),
            $this->createMock(ProtocolVersionInterface::class)
        );

        $this->assertInstanceOf(
            HeadersInterface::class,
            $request->headers()
        );
        $this->assertInstanceOf(
            StreamInterface::class,
            $request->body()
        );
        $this->assertInstanceOf(
            EnvironmentInterface::class,
            $request->environment()
        );
        $this->assertInstanceOf(
            CookiesInterface::class,
            $request->cookies()
        );
        $this->assertInstanceOf(
            QueryInterface::class,
            $request->query()
        );
        $this->assertInstanceOf(
            FormInterface::class,
            $request->form()
        );
        $this->assertInstanceOf(
            FilesInterface::class,
            $request->files()
        );
    }
}
