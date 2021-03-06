<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Message\Request;

use Innmind\Http\{
    Message,
    ProtocolVersion,
    Headers,
    Message\Request\Request,
    Message\Request as RequestInterface,
    Message\Method
};
use Innmind\Url\Url;
use Innmind\Stream\Readable;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function testInterface()
    {
        $r = new Request(
            $url = Url::of('example.com'),
            $method = Method::get(),
            $protocol = new ProtocolVersion(2, 0),
            $headers = Headers::of(),
            $body = $this->createMock(Readable::class)
        );

        $this->assertInstanceOf(Message::class, $r);
        $this->assertInstanceOf(RequestInterface::class, $r);
        $this->assertSame($url, $r->url());
        $this->assertSame($method, $r->method());
        $this->assertSame($protocol, $r->protocolVersion());
        $this->assertSame($headers, $r->headers());
        $this->assertSame($body, $r->body());
    }

    public function testDefaultValues()
    {
        $request = new Request(
            Url::of('example.com'),
            Method::get(),
            new ProtocolVersion(2, 0),
        );

        $this->assertInstanceOf(
            Headers::class,
            $request->headers()
        );
        $this->assertInstanceOf(
            Readable::class,
            $request->body()
        );
    }
}
