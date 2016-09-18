<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Message;

use Innmind\Http\{
    MessageInterface,
    ProtocolVersionInterface,
    HeadersInterface,
    Message\Request,
    Message\RequestInterface,
    Message\MethodInterface
};
use Innmind\Url\UrlInterface;
use Innmind\Filesystem\StreamInterface;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $r = new Request(
            $url = $this->createMock(UrlInterface::class),
            $method = $this->createMock(MethodInterface::class),
            $protocol = $this->createMock(ProtocolVersionInterface::class),
            $headers = $this->createMock(HeadersInterface::class),
            $body = $this->createMock(StreamInterface::class)
        );

        $this->assertInstanceOf(MessageInterface::class, $r);
        $this->assertInstanceOf(RequestInterface::class, $r);
        $this->assertSame($url, $r->url());
        $this->assertSame($method, $r->method());
        $this->assertSame($protocol, $r->protocolVersion());
        $this->assertSame($headers, $r->headers());
        $this->assertSame($body, $r->body());
    }
}
