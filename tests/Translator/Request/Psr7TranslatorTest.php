<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Translator\Request;

use Innmind\Http\{
    Translator\Request\Psr7Translator,
    Factory\Header\HeaderFactory,
    Factory\Header\Factories,
    Message\Request
};
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

        $request = ($translator)($request);

        $this->assertInstanceOf(Request::class, $request);
        $this->assertSame('/foo', $request->url()->toString());
        $this->assertSame('POST', $request->method()->toString());
        $this->assertSame('1.1', $request->protocolVersion()->toString());
        $headers = $request->headers();
        $this->assertCount(1, $headers);
        $this->assertSame(
            'content-type: application/json',
            $headers->get('content-type')->toString(),
        );
        $this->assertSame('content', $request->body()->toString());
    }

    public function testDefault()
    {
        $this->assertEquals(
            new Psr7Translator(Factories::default()),
            Psr7Translator::default(),
        );
    }
}
