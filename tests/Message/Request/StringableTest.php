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
use Innmind\Url\Url;
use Innmind\Filesystem\Stream\StringStream;
use PHPUnit\Framework\TestCase;

class StringableTest extends TestCase
{
    public function testInterface()
    {
        $request = new Request(
            $url = Url::fromString('http://example.com/foo/bar?query=string'),
            Method::post(),
            new ProtocolVersion(2, 0),
            Headers::of(
                new ContentType(
                    new ContentTypeValue('text', 'plain')
                )
            ),
            new StringStream('some body')
        );
        $stringable = new Stringable($request);

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
