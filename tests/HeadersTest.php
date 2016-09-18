<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http;

use Innmind\Http\{
    Headers,
    HeadersInterface,
    Header\HeaderInterface,
    Header\ContentType,
    Header\ContentTypeValue,
    Header\ParameterInterface
};
use Innmind\Immutable\Map;

class HeadersTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $hs = new Headers(
            (new Map('string', HeaderInterface::class))
                ->put(
                    'Content-Type',
                    $ct = new ContentType(
                        new ContentTypeValue(
                            'application',
                            'json',
                            new Map('string', ParameterInterface::class)
                        )
                    )
                )
        );

        $this->assertInstanceOf(HeadersInterface::class, $hs);
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

    /**
     * @expectedException Innmind\Http\Exception\HeaderNotFoundException
     */
    public function testThrowWhenAccessingUnknownHeader()
    {
        (new Headers(
            new Map('string', HeaderInterface::class)
        ))
            ->get('foo');
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenInvalidMap()
    {
        new Headers(new Map('string', 'string'));
    }
}