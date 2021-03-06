<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Translator\Response;

use Innmind\Http\{
    Translator\Response\Psr7Translator,
    Factory\Header\HeaderFactory,
    Factory\Header\Factories,
    Message\Response
};
use Psr\Http\Message\{
    ResponseInterface,
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
        $response = $this->createMock(ResponseInterface::class);
        $response
            ->expects($this->once())
            ->method('getStatusCode')
            ->willReturn(201);
        $response
            ->expects($this->once())
            ->method('getProtocolVersion')
            ->willReturn('1.1');
        $response
            ->expects($this->once())
            ->method('getHeaders')
            ->willReturn([
                'content-type' => ['application/json'],
            ]);
        $response
            ->expects($this->once())
            ->method('getBody')
            ->willReturn($stream = $this->createMock(StreamInterface::class));
        $stream
            ->expects($this->once())
            ->method('__toString')
            ->willReturn('content');

        $response = ($translator)($response);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertSame(201, $response->statusCode()->value());
        $this->assertSame('Created', $response->reasonPhrase()->toString());
        $this->assertSame('1.1', $response->protocolVersion()->toString());
        $headers = $response->headers();
        $this->assertCount(1, $headers);
        $this->assertSame(
            'content-type: application/json',
            $headers->get('content-type')->toString(),
        );
        $this->assertSame('content', $response->body()->toString());
    }

    public function testDefault()
    {
        $this->assertEquals(
            new Psr7Translator(Factories::default()),
            Psr7Translator::default(),
        );
    }
}
