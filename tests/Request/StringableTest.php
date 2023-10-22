<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Request;

use Innmind\Http\{
    Request\Stringable,
    Request,
    Method,
    ProtocolVersion,
    Headers,
    Header\ContentType,
    Header\ContentTypeValue
};
use Innmind\Filesystem\File\Content;
use Innmind\Url\Url;
use PHPUnit\Framework\TestCase;

class StringableTest extends TestCase
{
    public function testInterface()
    {
        $request = Request::of(
            $url = Url::of('http://example.com/foo/bar?query=string'),
            Method::post,
            ProtocolVersion::v20,
            Headers::of(
                new ContentType(
                    new ContentTypeValue('text', 'plain'),
                ),
            ),
            Content::ofString('some body'),
        );
        $stringable = Stringable::new()($request);

        $expected = <<<RAW
POST http://example.com/foo/bar?query=string HTTP/2.0
Content-Type: text/plain

some body
RAW;
        $this->assertSame($expected, $stringable->toString());
    }
}
