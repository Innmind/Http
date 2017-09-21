<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\{
    ContentRangeValue,
    HeaderValue
};
use PHPUnit\Framework\TestCase;

class ContentRangeValueTest extends TestCase
{
    public function testInterface()
    {
        $h = new ContentRangeValue('resources', 0, 42);

        $this->assertInstanceOf(HeaderValue::class, $h);
        $this->assertSame('resources', $h->unit());
        $this->assertSame(0, $h->firstPosition());
        $this->assertSame(42, $h->lastPosition());
        $this->assertFalse($h->isLengthKnown());
        $this->assertSame('resources 0-42/*', (string) $h);

        $h = new ContentRangeValue('bytes', 0, 499, 1234);
        $this->assertTrue($h->isLengthKnown());
        $this->assertSame(1234, $h->length());
        $this->assertSame('bytes 0-499/1234', (string) $h);
    }

    /**
     * @dataProvider invalids
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenInvalidContentRangeValue($unit, $first, $last, $length)
    {
        new ContentRangeValue($unit, $first, $last, $length);
    }

    public function invalids()
    {
        return [
            ['', 0, 42, null],
            ['foo', -1, 42, null],
            ['foo', 0, -42, null],
            ['foo', 0, 42, -42],
            ['foo', 100, 42, 142],
            ['foo', 100, 142, 42],
        ];
    }
}
