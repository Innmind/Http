<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http;

use Innmind\Http\{
    Headers,
    Header,
    Header\ContentType,
    Header\ContentTypeValue,
    Header\Parameter
};
use Innmind\Immutable\Map;
use PHPUnit\Framework\TestCase;

class HeadersTest extends TestCase
{
    public function testInterface()
    {
        $hs = new Headers(
            (new Map('string', Header::class))
                ->put(
                    'Content-Type',
                    $ct = new ContentType(
                        new ContentTypeValue(
                            'application',
                            'json',
                            new Map('string', Parameter::class)
                        )
                    )
                )
        );

        $this->assertTrue($hs->has('content-type'));
        $this->assertTrue($hs->has('Content-Type'));
        $this->assertFalse($hs->has('content_type'));
        $this->assertSame($ct, $hs->get('content-type'));
        $this->assertSame($ct, $hs->get('Content-Type'));
        $this->assertSame(1, $hs->count());
        $this->assertSame($ct, $hs->current());
        $this->assertSame('content-type', $hs->key());
        $this->assertTrue($hs->valid());
        $this->assertSame(null, $hs->next());
        $this->assertFalse($hs->valid());
        $this->assertSame(null, $hs->rewind());
        $this->assertTrue($hs->valid());
        $this->assertSame($ct, $hs->current());
    }

    public function testOf()
    {
        $headers = Headers::of(
            new ContentType(
                new ContentTypeValue(
                    'application',
                    'json',
                    new Map('string', Parameter::class)
                )
            )
        );

        $this->assertInstanceOf(Headers::class, $headers);
        $this->assertTrue($headers->has('content-type'));
    }

    /**
     * @expectedException Innmind\Http\Exception\HeaderNotFound
     */
    public function testThrowWhenAccessingUnknownHeader()
    {
        (new Headers)->get('foo');
    }

    /**
     * @expectedException TypeError
     * @expectedExceptionMessage Argument 1 must be of type MapInterface<string, Innmind\Http\Header>
     */
    public function testThrowWhenInvalidMap()
    {
        new Headers(new Map('string', 'string'));
    }
}
