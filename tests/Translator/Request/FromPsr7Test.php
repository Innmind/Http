<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Translator\Request;

use Innmind\Http\{
    Translator\Request\FromPsr7,
    Factory\Header\Factories,
    Factory\HeaderFactory,
    Message\Request
};
use Innmind\TimeContinuum\Earth\Clock;
use Innmind\Immutable\{
    Maybe,
    Str,
};
use Psr\Http\Message\{
    RequestInterface,
    StreamInterface
};
use PHPUnit\Framework\TestCase;

class FromPsr7Test extends TestCase
{
    public function testInterface()
    {
        $translator = new FromPsr7(
            new class implements HeaderFactory {
                public function __invoke(Str $name, Str $value): Maybe
                {
                    return Maybe::nothing();
                }
            },
        );
        $request = $this->createMock(RequestInterface::class);
        $request
            ->expects($this->once())
            ->method('getUri')
            ->willReturn('/foo');
        $request
            ->expects($this->once())
            ->method('getMethod')
            ->willReturn('post');
        $request
            ->expects($this->once())
            ->method('getProtocolVersion')
            ->willReturn('1.1');
        $request
            ->expects($this->once())
            ->method('getHeaders')
            ->willReturn([
                'content-type' => ['application/json'],
            ]);
        $request
            ->expects($this->once())
            ->method('getBody')
            ->willReturn($stream = $this->createMock(StreamInterface::class));
        $stream
            ->expects($this->once())
            ->method('__toString')
            ->willReturn('content');

        $request = ($translator)($request);

        $this->assertInstanceOf(Request::class, $request);
        $this->assertSame('/foo', $request->url()->toString());
        $this->assertSame('POST', $request->method()->toString());
        $this->assertSame('1.1', $request->protocolVersion()->toString());
        $headers = $request->headers();
        $this->assertCount(1, $headers);
        $this->assertSame(
            'content-type: application/json',
            $headers->get('content-type')->match(
                static fn($header) => $header->toString(),
                static fn() => null,
            ),
        );
        $this->assertSame('content', $request->body()->toString());
    }

    public function testDefault()
    {
        $this->assertEquals(
            new FromPsr7(Factories::default(new Clock)),
            FromPsr7::default(new Clock),
        );
    }
}
