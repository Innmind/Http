<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Translator\Response;

use Innmind\Http\{
    Translator\Response\SymfonyTranslator,
    Message\Response\Response,
    Message\StatusCode,
    Message\ReasonPhrase,
    ProtocolVersion,
    Headers,
    Header\Header,
    Header\Value\Value
};
use Innmind\Filesystem\Stream\StringStream;
use Symfony\Component\HttpFoundation\Response as SfResponse;
use PHPUnit\Framework\TestCase;

class SymfonyTranslatorTest extends TestCase
{
    public function testTranslate()
    {
        $translator = new SymfonyTranslator;
        $response = new Response(
            new StatusCode(200),
            new ReasonPhrase('OK'),
            new ProtocolVersion(2, 0),
            Headers::of(
                new Header('foo', new Value('bar'), new Value('baz')),
                new Header('foobar', new Value('barbar'), new Value('bazbar'))
            ),
            new StringStream('watev')
        );

        $response = ($translator)($response);

        $this->assertInstanceOf(SfResponse::class, $response);
        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('watev', $response->getContent());
        $this->assertSame(
            [
                'foo' => ['bar', 'baz'],
                'foobar' => ['barbar', 'bazbar'],
                'cache-control' => ['no-cache, private'],
                'date' => [date('D, d M Y H:i:s').' GMT'],
            ],
            $response->headers->all()
        );
    }
}
