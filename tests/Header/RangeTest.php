<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\{
    Range,
    HeaderInterface,
    HeaderValueInterface,
    RangeValue
};
use Innmind\Immutable\SetInterface;

class RangeTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $h = new Range(
            $cr = new RangeValue('bytes', 0, 42)
        );

        $this->assertInstanceOf(HeaderInterface::class, $h);
        $this->assertSame('Range', $h->name());
        $v = $h->values();
        $this->assertInstanceOf(SetInterface::class, $v);
        $this->assertSame(HeaderValueInterface::class, (string) $v->type());
        $this->assertSame($cr, $v->current());
        $this->assertSame('Range : bytes=0-42', (string) $h);
    }
}
