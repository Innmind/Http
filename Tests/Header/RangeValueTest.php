<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Header;

use Innmind\Http\Header\{
    RangeValue,
    HeaderValueInterface
};

class RangeValueTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $h = new RangeValue('resources', 0, 42);

        $this->assertInstanceOf(HeaderValueInterface::class, $h);
        $this->assertSame('resources', $h->unit());
        $this->assertSame(0, $h->firstPosition());
        $this->assertSame(42, $h->lastPosition());
        $this->assertSame('resources=0-42', (string) $h);
    }

    /**
     * @dataProvider invalids
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
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
