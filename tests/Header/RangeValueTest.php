<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\{
    RangeValue,
    Value
};
use PHPUnit\Framework\TestCase;

class RangeValueTest extends TestCase
{
    public function testInterface()
    {
        $h = new RangeValue('resources', 0, 42);

        $this->assertInstanceOf(Value::class, $h);
        $this->assertSame('resources', $h->unit());
        $this->assertSame(0, $h->firstPosition());
        $this->assertSame(42, $h->lastPosition());
        $this->assertSame('resources=0-42', $h->toString());
    }

    /**
     * @dataProvider invalids
     * @expectedException Innmind\Http\Exception\DomainException
     */
    public function testThrowWhenInvalidRangeValue($unit, $first, $last)
    {
        new RangeValue($unit, $first, $last);
    }

    public function invalids()
    {
        return [
            ['', 0, 42],
            ['foo', -1, 42],
            ['foo', 0, -42],
            ['foo', 100, 42],
        ];
    }
}
