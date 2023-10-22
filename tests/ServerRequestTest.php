<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http;

use Innmind\Http\{
    ServerRequest,
    ProtocolVersion,
    Headers,
    Method,
    ServerRequest\Environment,
    ServerRequest\Cookies,
    ServerRequest\Query,
    ServerRequest\Form,
    ServerRequest\Files
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
            $method = Method::get,
            $protocol = ProtocolVersion::v20,
            $headers = Headers::of(),
            $body = Content::none(),
            $env = new Environment,
            $cookies = new Cookies,
            $query = Query::of([]),
            $form = Form::of([]),
            $files = Files::of([]),
        );

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
            Method::get,
            ProtocolVersion::v11,
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
