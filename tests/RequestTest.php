<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Message\Request;

use Innmind\Http\{
    Request,
    ProtocolVersion,
    Headers,
    Method,
};
use Innmind\Filesystem\File\Content;
use Innmind\Url\Url;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function testInterface()
    {
        $r = Request::of(
            $url = Url::of('example.com'),
            $method = Method::get,
            $protocol = ProtocolVersion::v20,
            $headers = Headers::of(),
            $body = Content::none(),
        );

        $this->assertSame($url, $r->url());
        $this->assertSame($method, $r->method());
        $this->assertSame($protocol, $r->protocolVersion());
        $this->assertSame($headers, $r->headers());
        $this->assertSame($body, $r->body());
    }

    public function testDefaultValues()
    {
        $request = Request::of(
            Url::of('example.com'),
            Method::get,
            ProtocolVersion::v20,
        );

        $this->assertInstanceOf(
            Headers::class,
            $request->headers(),
        );
        $this->assertInstanceOf(
            Content::class,
            $request->body(),
        );
    }
}
