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
use Innmind\Filesystem\File\Content;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    public function testInterface()
    {
        $r = new Response(
            $status = StatusCode::ok,
            $reason = new ReasonPhrase('OK'),
            $protocol = new ProtocolVersion(2, 0),
            $headers = Headers::of(),
            $body = $this->createMock(Content::class),
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
            StatusCode::ok,
            new ReasonPhrase('OK'),
            new ProtocolVersion(2, 0),
        );

        $this->assertInstanceOf(
            Headers::class,
            $response->headers(),
        );
        $this->assertInstanceOf(
            Content::class,
            $response->body(),
        );
    }
}
