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
};
use Innmind\Filesystem\File\Content;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    public function testInterface()
    {
        $r = new Response(
            $status = StatusCode::ok,
            $protocol = ProtocolVersion::v20,
            $headers = Headers::of(),
            $body = $this->createMock(Content::class),
        );

        $this->assertInstanceOf(Message::class, $r);
        $this->assertInstanceOf(ResponseInterface::class, $r);
        $this->assertSame($status, $r->statusCode());
        $this->assertSame($protocol, $r->protocolVersion());
        $this->assertSame($headers, $r->headers());
        $this->assertSame($body, $r->body());
    }

    public function testDefaultValues()
    {
        $response = new Response(
            StatusCode::ok,
            ProtocolVersion::v20,
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
