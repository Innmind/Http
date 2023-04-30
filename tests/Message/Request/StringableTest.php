<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Message\Request;

use Innmind\Http\{
    Message\Request\Stringable,
    Message\Request\Request,
    Message\Request as RequestInterface,
    Message\Method,
    ProtocolVersion,
    Headers,
    Header\ContentType,
    Header\ContentTypeValue
};
use Innmind\Filesystem\File\Content\Lines;
use Innmind\Url\Url;
use PHPUnit\Framework\TestCase;

class StringableTest extends TestCase
{
    public function testInterface()
    {
        $request = new Request(
            $url = Url::of('http://example.com/foo/bar?query=string'),
            Method::post,
            ProtocolVersion::v20,
            Headers::of(
                new ContentType(
                    new ContentTypeValue('text', 'plain'),
                ),
            ),
            Lines::ofContent('some body'),
        );
        $stringable = Stringable::of($request);

        $this->assertInstanceOf(RequestInterface::class, $stringable);
        $this->assertSame($request->url(), $stringable->url());
        $this->assertSame($request->method(), $stringable->method());
        $this->assertSame($request->protocolVersion(), $stringable->protocolVersion());
        $this->assertSame($request->headers(), $stringable->headers());
        $this->assertSame($request->body(), $stringable->body());
        $expected = <<<RAW
POST http://example.com/foo/bar?query=string HTTP/2.0
Content-Type: text/plain

some body
RAW;
        $this->assertSame($expected, $stringable->toString());
    }
}
