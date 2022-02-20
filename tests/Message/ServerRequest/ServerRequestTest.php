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
use Innmind\Filesystem\File\Content;
use Innmind\Url\Url;
use PHPUnit\Framework\TestCase;

class ServerRequestTest extends TestCase
{
    public function testInterface()
    {
        $r = new ServerRequest(
            $url = Url::of('example.com'),
            $method = Method::get(),
            $protocol = new ProtocolVersion(2, 0),
            $headers = Headers::of(),
            $body = $this->createMock(Content::class),
            $env = new Environment,
            $cookies = new Cookies,
            $query = Query::of(),
            $form = Form::of(),
            $files = new Files,
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
            Url::of('example.com'),
            Method::get(),
            new ProtocolVersion(1, 1),
        );

        $this->assertInstanceOf(
            Headers::class,
            $request->headers(),
        );
        $this->assertInstanceOf(
            Content::class,
            $request->body(),
        );
        $this->assertInstanceOf(
            Environment::class,
            $request->environment(),
        );
        $this->assertInstanceOf(
            Cookies::class,
            $request->cookies(),
        );
        $this->assertInstanceOf(
            Query::class,
            $request->query(),
        );
        $this->assertInstanceOf(
            Form::class,
            $request->form(),
        );
        $this->assertInstanceOf(
            Files::class,
            $request->files(),
        );
    }
}
