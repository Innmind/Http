<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\ContentRangeValue,
    Header\Value,
    Exception\DomainException,
};
use PHPUnit\Framework\TestCase;

class ContentRangeValueTest extends TestCase
{
    public function testInterface()
    {
        $h = new ContentRangeValue('resources', 0, 42);

        $this->assertInstanceOf(Value::class, $h);
        $this->assertSame('resources', $h->unit());
        $this->assertSame(0, $h->firstPosition());
        $this->assertSame(42, $h->lastPosition());
        $this->assertFalse($h->length()->match(
            static fn() => true,
            static fn() => false,
        ));
        $this->assertSame('resources 0-42/*', $h->toString());

        $h = new ContentRangeValue('bytes', 0, 499, 1234);
        $this->assertSame(1234, $h->length()->match(
            static fn($length) => $length,
            static fn() => null,
        ));
        $this->assertSame('bytes 0-499/1234', $h->toString());
    }

    /**
     * @dataProvider invalids
     */
    public function testThrowWhenInvalidContentRangeValue($unit, $first, $last, $length)
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage($unit);

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
