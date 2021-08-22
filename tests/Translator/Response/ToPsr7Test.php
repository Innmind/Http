<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Translator\Response;

use Innmind\Http\{
    Translator\Response\ToPsr7,
    Message\Response\Response,
    Message\StatusCode,
    ProtocolVersion,
    Headers,
    Header\ContentType,
    Stream\ToPsr7 as Stream,
};
use Innmind\Stream\Readable;
use Psr\Http\Message\ResponseInterface;
use PHPUnit\Framework\TestCase;

class ToPsr7Test extends TestCase
{
    public function testTranslate()
    {
        $translate = new ToPsr7;

        $response = $translate(new Response(
            $code = StatusCode::of('CREATED'),
            $code->associatedReasonPhrase(),
            new ProtocolVersion(1, 1),
            Headers::of(
                ContentType::of('text', 'plain'),
            ),
            $body = $this->createMock(Readable::class),
        ));

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertSame(201, $response->getStatusCode());
        $this->assertSame('Created', $response->getReasonPhrase());
        $this->assertSame('1.1', $response->getProtocolVersion());
        $this->assertSame(['Content-Type' => ['text/plain']], $response->getHeaders());
        $this->assertEquals(new Stream($body), $response->getBody());
    }
}
