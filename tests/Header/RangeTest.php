<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\Range,
    Header,
    Header\Value,
    Header\RangeValue
};
use Innmind\Immutable\Set;
use function Innmind\Immutable\first;
use PHPUnit\Framework\TestCase;

class RangeTest extends TestCase
{
    public function testInterface()
    {
        $h = new Range(
            $cr = new RangeValue('bytes', 0, 42)
        );

        $this->assertInstanceOf(Header::class, $h);
        $this->assertSame('Range', $h->name());
        $v = $h->values();
        $this->assertInstanceOf(Set::class, $v);
        $this->assertSame(Value::class, (string) $v->type());
        $this->assertSame($cr, first($v));
        $this->assertSame('Range: bytes=0-42', $h->toString());
    }

    public function testOf()
    {
        $header = Range::of('bytes', 0, 42);

        $this->assertInstanceOf(Range::class, $header);
        $this->assertSame('Range: bytes=0-42', $header->toString());
    }
}
