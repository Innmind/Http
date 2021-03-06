<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Message\ServerRequest;

use Innmind\Http\{
    Message\ServerRequest\Stringable,
    Message\ServerRequest\ServerRequest,
    Message\ServerRequest as ServerRequestInterface,
    Message\Method,
    Message\Query,
    Message\Form,
    ProtocolVersion,
    Headers,
    Header\Host,
    Header\HostValue
};
use Innmind\Url\Url;
use Innmind\Stream\Readable\Stream;
use PHPUnit\Framework\TestCase;

class StringableTest extends TestCase
{
    public function testInterface()
    {
        $request = new ServerRequest(
            $url = Url::of('http://example.com/foo/bar'),
            Method::post(),
            new ProtocolVersion(2, 0),
            Headers::of(
                new Host(
                    new HostValue(
                        $url->authority()->host(),
                        $url->authority()->port()
                    )
                )
            ),
            Stream::ofContent('some body')
        );
        $stringable = new Stringable($request);

        $this->assertInstanceOf(ServerRequestInterface::class, $stringable);
        $this->assertSame($request->url(), $stringable->url());
        $this->assertSame($request->method(), $stringable->method());
        $this->assertSame($request->protocolVersion(), $stringable->protocolVersion());
        $this->assertSame($request->headers(), $stringable->headers());
        $this->assertSame($request->body(), $stringable->body());
        $this->assertSame($request->environment(), $stringable->environment());
        $this->assertSame($request->cookies(), $stringable->cookies());
        $this->assertSame($request->query(), $stringable->query());
        $this->assertSame($request->form(), $stringable->form());
        $this->assertSame($request->files(), $stringable->files());
        $expected = <<<RAW
POST /foo/bar HTTP/2.0
Host: example.com

some body
RAW;
        $this->assertSame($expected, $stringable->toString());
    }

    public function testIntegrateQuery()
    {
        $request = new ServerRequest(
            $url = Url::of('http://example.com/foo/bar'),
            Method::post(),
            new ProtocolVersion(2, 0),
            Headers::of(
                new Host(
                    new HostValue(
                        $url->authority()->host(),
                        $url->authority()->port()
                    )
                )
            ),
            Stream::ofContent('some body'),
            null,
            null,
            Query::of(
                new Query\Parameter('foo', 'bar'),
                new Query\Parameter('bar', '42'),
                new Query\Parameter('baz', ['foo'])
            )
        );
        $stringable = new Stringable($request);

        $this->assertInstanceOf(ServerRequestInterface::class, $stringable);
        $this->assertSame($request->url(), $stringable->url());
        $this->assertSame($request->method(), $stringable->method());
        $this->assertSame($request->protocolVersion(), $stringable->protocolVersion());
        $this->assertSame($request->headers(), $stringable->headers());
        $this->assertSame($request->body(), $stringable->body());
        $this->assertSame($request->environment(), $stringable->environment());
        $this->assertSame($request->cookies(), $stringable->cookies());
        $this->assertSame($request->query(), $stringable->query());
        $this->assertSame($request->form(), $stringable->form());
        $this->assertSame($request->files(), $stringable->files());
        $expected = <<<RAW
POST /foo/bar?foo=bar&bar=42&baz[0]=foo HTTP/2.0
Host: example.com

some body
RAW;
        $this->assertSame($expected, $stringable->toString());
    }

    public function testIntegrateFormWhenNoBody()
    {
        $request = new ServerRequest(
            $url = Url::of('http://example.com/foo/bar'),
            Method::post(),
            new ProtocolVersion(2, 0),
            Headers::of(
                new Host(
                    new HostValue(
                        $url->authority()->host(),
                        $url->authority()->port()
                    )
                )
            ),
            null,
            null,
            null,
            null,
            Form::of(
                new Form\Parameter('foo', 'bar'),
                new Form\Parameter('bar', '42'),
                new Form\Parameter(
                    'baz',
                    ['foo'],
                ),
            ),
        );
        $stringable = new Stringable($request);

        $this->assertInstanceOf(ServerRequestInterface::class, $stringable);
        $this->assertSame($request->url(), $stringable->url());
        $this->assertSame($request->method(), $stringable->method());
        $this->assertSame($request->protocolVersion(), $stringable->protocolVersion());
        $this->assertSame($request->headers(), $stringable->headers());
        $this->assertSame($request->body(), $stringable->body());
        $this->assertSame($request->environment(), $stringable->environment());
        $this->assertSame($request->cookies(), $stringable->cookies());
        $this->assertSame($request->query(), $stringable->query());
        $this->assertSame($request->form(), $stringable->form());
        $this->assertSame($request->files(), $stringable->files());
        $expected = <<<RAW
POST /foo/bar HTTP/2.0
Host: example.com

foo=bar&bar=42&baz[0]=foo
RAW;
        $this->assertSame($expected, $stringable->toString());
    }
}
