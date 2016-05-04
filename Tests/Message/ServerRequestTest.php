<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Message;

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

class ServerRequestTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $r = new ServerRequest(
            $url = $this->getMock(UrlInterface::class),
            $method = $this->getMock(MethodInterface::class),
            $protocol = $this->getMock(ProtocolVersionInterface::class),
            $headers = $this->getMock(HeadersInterface::class),
            $body = $this->getMock(StreamInterface::class),
            $env = $this->getMock(EnvironmentInterface::class),
            $cookies = $this->getMock(CookiesInterface::class),
            $query = $this->getMock(QueryInterface::class),
            $form = $this->getMock(FormInterface::class),
            $files = $this->getMock(FilesInterface::class)
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
}
