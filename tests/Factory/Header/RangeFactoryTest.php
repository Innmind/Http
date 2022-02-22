<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\RangeFactory,
    Factory\HeaderFactory,
    Header\Range,
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
        )->match(
            static fn($header) => $header,
            static fn() => null,
        );

        $this->assertInstanceOf(Range::class, $h);
        $this->assertSame(
            'Range: bytes=0-42',
            $h->toString(),
        );
    }

    public function testReturnNothingWhenNotExpectedHeader()
    {
        $this->assertNull((new RangeFactory)(
            Str::of('foo'),
            Str::of(''),
        )->match(
            static fn($header) => $header,
            static fn() => null,
        ));
    }

    public function testReturnNothingWhenNotValid()
    {
        $this->assertNull((new RangeFactory)(
            Str::of('Range'),
            Str::of('foo'),
        )->match(
            static fn($header) => $header,
            static fn() => null,
        ));
    }
}
