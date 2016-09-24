<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\RangeFactory,
    Factory\HeaderFactoryInterface,
    Header\Range
};
use Innmind\Immutable\StringPrimitive as Str;

class RangeFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testMake()
    {
        $f = new RangeFactory;

        $this->assertInstanceOf(HeaderFactoryInterface::class, $f);

        $h = $f->make(
            new Str('Range'),
            new Str('bytes=0-42')
        );

        $this->assertInstanceOf(Range::class, $h);
        $this->assertSame(
            'Range : bytes=0-42',
            (string) $h
        );
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenNotExpectedHeader()
    {
        (new RangeFactory)->make(
            new Str('foo'),
            new Str('')
        );
    }
}
