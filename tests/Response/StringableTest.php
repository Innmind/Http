<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Response;

use Innmind\Http\{
    Response\Stringable,
    Response,
    Response\StatusCode,
    ProtocolVersion,
    Headers,
    Header\ContentType,
    Header\Allow,
    Method,
};
use Innmind\Filesystem\File\Content;
use Innmind\MediaType\MediaType;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class StringableTest extends TestCase
{
    public function testInterface()
    {
        $response = Response::of(
            $code = StatusCode::ok,
            ProtocolVersion::v20,
            Headers::of(
                ContentType::of(
                    MediaType::of('text/plain'),
                ),
                Allow::of(Method::get),
            ),
            Content::ofString('{"some":"json", "value":42}'),
        );
        $stringable = Stringable::new()($response);

        $expected = <<<RAW
HTTP/2.0 200 OK
Content-Type: text/plain
Allow: GET

{"some":"json", "value":42}
RAW;

        $this->assertSame($expected, $stringable->toString());
    }
}
