<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\RangeFactory,
    Factory\HeaderFactory,
    Header\Range
};
use Innmind\Immutable\Str;
use PHPUnit\Framework\TestCase;

class RangeFactoryTest extends TestCase
{
    public function testMake()
    {
        $f = new RangeFactory;

        $this->assertInstanceOf(HeaderFactory::class, $f);

        $h = $f->make(
            new Str('Range'),
            new Str('bytes=0-42')
        );

        $this->assertInstanceOf(Range::class, $h);
        $this->assertSame(
            'Range: bytes=0-42',
            (string) $h
        );
    }

    /**
     * @expectedException Innmind\Http\Exception\DomainException
     */
    public function testThrowWhenNotExpectedHeader()
    {
        (new RangeFactory)->make(
            new Str('foo'),
            new Str('')
        );
    }

    /**
     * @expectedException Innmind\Http\Exception\DomainException
     */
    public function testThrowWhenNotValid()
    {
        (new RangeFactory)->make(
            new Str('Range'),
            new Str('foo')
        );
    }
}
