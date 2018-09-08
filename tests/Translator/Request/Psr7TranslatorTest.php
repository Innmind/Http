<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Translator\Request;

use Innmind\Http\{
    Translator\Request\Psr7Translator,
    Factory\Header\HeaderFactory,
    Message\Request
};
use Innmind\Immutable\Map;
use Psr\Http\Message\{
    RequestInterface,
    StreamInterface
};
use PHPUnit\Framework\TestCase;

class Psr7TranslatorTest extends TestCase
{
    public function testInterface()
    {
        $translator = new Psr7Translator(
            new HeaderFactory
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

        $request = $translator->translate($request);

        $this->assertInstanceOf(Request::class, $request);
        $this->assertSame('/foo', (string) $request->url());
        $this->assertSame('POST', (string) $request->method());
        $this->assertSame('1.1', (string) $request->protocolVersion());
        $headers = $request->headers();
        $this->assertCount(1, $headers);
        $this->assertSame(
            'content-type: application/json',
            (string) $headers->get('content-type')
        );
        $this->assertSame('content', (string) $request->body());
    }
}
