<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Message;

use Innmind\Http\{
    MessageInterface,
    ProtocolVersionInterface,
    HeadersInterface,
    Message\Response,
    Message\ResponseInterface,
    Message\StatusCodeInterface,
    Message\ReasonPhraseInterface
};
use Innmind\Filesystem\StreamInterface;

class ResponseTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $r = new Response(
            $status = $this->getMock(StatusCodeInterface::class),
            $reason = $this->getMock(ReasonPhraseInterface::class),
            $protocol = $this->getMock(ProtocolVersionInterface::class),
            $headers = $this->getMock(HeadersInterface::class),
            $body = $this->getMock(StreamInterface::class)
        );

        $this->assertInstanceOf(MessageInterface::class, $r);
        $this->assertInstanceOf(ResponseInterface::class, $r);
        $this->assertSame($status, $r->statusCode());
        $this->assertSame($reason, $r->reasonPhrase());
        $this->assertSame($protocol, $r->protocolVersion());
        $this->assertSame($headers, $r->headers());
        $this->assertSame($body, $r->body());
    }
}
