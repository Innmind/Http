<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\Range,
    Header,
};
use Innmind\Immutable\Sequence;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class RangeTest extends TestCase
{
    public function testInterface()
    {
        $h = Range::of('bytes', 0, 42);

        $this->assertInstanceOf(Header::class, $h);
        $this->assertSame('Range', $h->name());
        $v = $h->values();
        $this->assertInstanceOf(Sequence::class, $v);
        $this->assertSame('Range: bytes=0-42', $h->toString());
    }

    public function testOf()
    {
        $header = Range::of('bytes', 0, 42);

        $this->assertInstanceOf(Range::class, $header);
        $this->assertSame('Range: bytes=0-42', $header->toString());
    }

    public function testValid()
    {
        $this->assertSame(
            'Range: resources=0-42',
            Range::of('resources', 0, 42)->toString(),
        );
    }

    #[DataProvider('invalids')]
    public function testReturnNothingWhenInvalidRangeValue($unit, $first, $last)
    {
        $this->assertNull(Range::maybe($unit, $first, $last)->match(
            static fn($header) => $header,
            static fn() => null,
        ));
    }

    public static function invalids()
    {
        return [
            ['', 0, 42],
            ['foo', -1, 42],
            ['foo', 0, -42],
            ['foo', 100, 42],
        ];
    }
}
