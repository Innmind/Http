<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http;

use Innmind\Http\{
    Response,
    ProtocolVersion,
    Headers,
    Response\StatusCode,
};
use Innmind\Filesystem\File\Content;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    public function testInterface()
    {
        $r = Response::of(
            $status = StatusCode::ok,
            $protocol = ProtocolVersion::v20,
            $headers = Headers::of(),
            $body = Content::none(),
        );

        $this->assertSame($status, $r->statusCode());
        $this->assertSame($protocol, $r->protocolVersion());
        $this->assertSame($headers, $r->headers());
        $this->assertSame($body, $r->body());
    }

    public function testDefaultValues()
    {
        $response = Response::of(
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
