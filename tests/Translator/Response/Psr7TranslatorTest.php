<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Translator\Response;

use Innmind\Http\{
    Translator\Response\Psr7Translator,
    Factory\Header\HeaderFactory,
    Message\Response
};
use Innmind\Immutable\Map;
use Psr\Http\Message\{
    ResponseInterface,
    StreamInterface
};

class Psr7TranslatorTest extends \PHPUnit_Framework_TestCase
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

        $response = $translator->translate($response);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertSame(201, $response->statusCode()->value());
        $this->assertSame('Created', (string) $response->reasonPhrase());
        $this->assertSame('1.1', (string) $response->protocolVersion());
        $headers = $response->headers();
        $this->assertCount(1, $headers);
        $this->assertSame(
            'content-type : application/json',
            (string) $headers->get('content-type')
        );
        $this->assertSame('content', (string) $response->body());
    }
}
