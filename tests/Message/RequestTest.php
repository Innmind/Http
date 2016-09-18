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
            $url = $this->getMock(UrlInterface::class),
            $method = $this->getMock(MethodInterface::class),
            $protocol = $this->getMock(ProtocolVersionInterface::class),
            $headers = $this->getMock(HeadersInterface::class),
            $body = $this->getMock(StreamInterface::class)
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
