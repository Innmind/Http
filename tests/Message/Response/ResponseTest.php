<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Message\Response;

use Innmind\Http\{
    Message,
    ProtocolVersion,
    Headers,
    Message\Response\Response,
    Message\Response as ResponseInterface,
    Message\StatusCode,
    Message\ReasonPhrase
};
use Innmind\Stream\Readable;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    public function testInterface()
    {
        $r = new Response(
            $status = $this->createMock(StatusCode::class),
            $reason = $this->createMock(ReasonPhrase::class),
            $protocol = new ProtocolVersion(2, 0),
            $headers = $this->createMock(Headers::class),
            $body = $this->createMock(Readable::class)
        );

        $this->assertInstanceOf(Message::class, $r);
        $this->assertInstanceOf(ResponseInterface::class, $r);
        $this->assertSame($status, $r->statusCode());
        $this->assertSame($reason, $r->reasonPhrase());
        $this->assertSame($protocol, $r->protocolVersion());
        $this->assertSame($headers, $r->headers());
        $this->assertSame($body, $r->body());
    }

    public function testDefaultValues()
    {
        $response = new Response(
            $this->createMock(StatusCode::class),
            $this->createMock(ReasonPhrase::class),
            new ProtocolVersion(2, 0),
        );

        $this->assertInstanceOf(
            Headers::class,
            $response->headers()
        );
        $this->assertInstanceOf(
            Readable::class,
            $response->body()
        );
    }
}
