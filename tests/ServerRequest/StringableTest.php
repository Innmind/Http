<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\ServerRequest;

use Innmind\Http\{
    ServerRequest\Stringable,
    ServerRequest,
    Method,
    ServerRequest\Query,
    ServerRequest\Form,
    ProtocolVersion,
    Headers,
    Header\Host,
};
use Innmind\Filesystem\File\Content;
use Innmind\Url\Url;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class StringableTest extends TestCase
{
    public function testInterface()
    {
        $request = ServerRequest::of(
            $url = Url::of('http://example.com/foo/bar'),
            Method::post,
            ProtocolVersion::v20,
            Headers::of(
                Host::of(
                    $url->authority()->host(),
                    $url->authority()->port(),
                ),
            ),
            Content::ofString('some body'),
        );
        $stringable = Stringable::new()($request);

        $expected = <<<RAW
POST /foo/bar HTTP/2.0
Host: example.com

some body
RAW;
        $this->assertSame($expected, $stringable->toString());
    }

    public function testIntegrateQuery()
    {
        $request = ServerRequest::of(
            $url = Url::of('http://example.com/foo/bar'),
            Method::post,
            ProtocolVersion::v20,
            Headers::of(
                Host::of(
                    $url->authority()->host(),
                    $url->authority()->port(),
                ),
            ),
            Content::ofString('some body'),
            null,
            null,
            Query::of([
                'foo' => 'bar',
                'bar' => '42',
                'baz' => ['foo'],
            ]),
        );
        $stringable = Stringable::new()($request);

        $expected = <<<RAW
POST /foo/bar?foo=bar&bar=42&baz[0]=foo HTTP/2.0
Host: example.com

some body
RAW;
        $this->assertSame($expected, $stringable->toString());
    }

    public function testIntegrateFormWhenNoBody()
    {
        $request = ServerRequest::of(
            $url = Url::of('http://example.com/foo/bar'),
            Method::post,
            ProtocolVersion::v20,
            Headers::of(
                Host::of(
                    $url->authority()->host(),
                    $url->authority()->port(),
                ),
            ),
            null,
            null,
            null,
            null,
            Form::of([
                'foo' => 'bar',
                'bar' => '42',
                'baz' => ['foo'],
            ]),
        );
        $stringable = Stringable::new()($request);

        $expected = <<<RAW
POST /foo/bar HTTP/2.0
Host: example.com

foo=bar&bar=42&baz[0]=foo
RAW;
        $this->assertSame($expected, $stringable->toString());
    }
}
