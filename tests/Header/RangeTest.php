<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\Range,
    Header,
    Header\HeaderValue,
    Header\RangeValue
};
use Innmind\Immutable\SetInterface;
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
        $this->assertInstanceOf(SetInterface::class, $v);
        $this->assertSame(HeaderValue::class, (string) $v->type());
        $this->assertSame($cr, $v->current());
        $this->assertSame('Range : bytes=0-42', (string) $h);
    }
}
