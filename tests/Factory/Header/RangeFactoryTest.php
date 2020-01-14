<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\RangeFactory,
    Factory\HeaderFactory,
    Header\Range,
    Exception\DomainException,
};
use Innmind\Immutable\Str;
use PHPUnit\Framework\TestCase;

class RangeFactoryTest extends TestCase
{
    public function testMake()
    {
        $f = new RangeFactory;

        $this->assertInstanceOf(HeaderFactory::class, $f);

        $h = ($f)(
            Str::of('Range'),
            Str::of('bytes=0-42'),
        );

        $this->assertInstanceOf(Range::class, $h);
        $this->assertSame(
            'Range: bytes=0-42',
            $h->toString(),
        );
    }

    public function testThrowWhenNotExpectedHeader()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('foo');

        (new RangeFactory)(
            Str::of('foo'),
            Str::of(''),
        );
    }

    public function testThrowWhenNotValid()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Range');

        (new RangeFactory)(
            Str::of('Range'),
            Str::of('foo'),
        );
    }
}
