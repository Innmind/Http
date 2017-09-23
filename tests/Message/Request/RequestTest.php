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
use Innmind\Url\UrlInterface;
use Innmind\Stream\Readable;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function testInterface()
    {
        $r = new Request(
            $url = $this->createMock(UrlInterface::class),
            $method = $this->createMock(Method::class),
            $protocol = $this->createMock(ProtocolVersion::class),
            $headers = $this->createMock(Headers::class),
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
            $this->createMock(UrlInterface::class),
            $this->createMock(Method::class),
            $this->createMock(ProtocolVersion::class)
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
