<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Message\Response;

use Innmind\Http\{
    Message\Response\Stringable,
    Response,
    Message\StatusCode,
    ProtocolVersion,
    Headers,
    Header\ContentType,
    Header\ContentTypeValue,
    Header\Allow,
    Header\AllowValue
};
use Innmind\Filesystem\File\Content;
use PHPUnit\Framework\TestCase;

class StringableTest extends TestCase
{
    public function testInterface()
    {
        $response = new Response(
            $code = StatusCode::ok,
            ProtocolVersion::v20,
            Headers::of(
                new ContentType(
                    new ContentTypeValue('text', 'plain'),
                ),
                new Allow(
                    new AllowValue('GET'),
                ),
            ),
            Content::ofString('{"some":"json", "value":42}'),
        );
        $stringable = Stringable::of($response);

        $this->assertSame($response->statusCode(), $stringable->statusCode());
        $this->assertSame($response->protocolVersion(), $stringable->protocolVersion());
        $this->assertSame($response->headers(), $stringable->headers());
        $this->assertSame($response->body(), $stringable->body());
        $expected = <<<RAW
HTTP/2.0 200 OK
Content-Type: text/plain
Allow: GET

{"some":"json", "value":42}
RAW;

        $this->assertSame($expected, $stringable->toString());
    }
}
