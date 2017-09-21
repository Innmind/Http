<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Message\ServerRequest;

use Innmind\Http\{
    Message,
    ProtocolVersion,
    Headers,
    Message\ServerRequest\ServerRequest,
    Message\Request,
    Message\ServerRequest as ServerRequestInterface,
    Message\Method,
    Message\Environment,
    Message\Cookies,
    Message\Query,
    Message\Form,
    Message\Files
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
            $method = $this->createMock(Method::class),
            $protocol = $this->createMock(ProtocolVersion::class),
            $headers = $this->createMock(Headers::class),
            $body = $this->createMock(StreamInterface::class),
            $env = $this->createMock(Environment::class),
            $cookies = $this->createMock(Cookies::class),
            $query = $this->createMock(Query::class),
            $form = $this->createMock(Form::class),
            $files = $this->createMock(Files::class)
        );

        $this->assertInstanceOf(Message::class, $r);
        $this->assertInstanceOf(Request::class, $r);
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
            $this->createMock(Method::class),
            $this->createMock(ProtocolVersion::class)
        );

        $this->assertInstanceOf(
            Headers::class,
            $request->headers()
        );
        $this->assertInstanceOf(
            StreamInterface::class,
            $request->body()
        );
        $this->assertInstanceOf(
            Environment::class,
            $request->environment()
        );
        $this->assertInstanceOf(
            Cookies::class,
            $request->cookies()
        );
        $this->assertInstanceOf(
            Query::class,
            $request->query()
        );
        $this->assertInstanceOf(
            Form::class,
            $request->form()
        );
        $this->assertInstanceOf(
            Files::class,
            $request->files()
        );
    }
}
