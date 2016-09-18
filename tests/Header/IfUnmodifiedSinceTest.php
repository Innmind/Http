<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\{
    IfUnmodifiedSince,
    HeaderInterface,
    HeaderValueInterface,
    DateValue
};
use Innmind\Immutable\SetInterface;

class IfUnmodifiedSinceTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $h = new IfUnmodifiedSince(
            $d = new DateValue(new \DateTime('2016-01-01 12:12:12+0200'))
        );

        $this->assertInstanceOf(HeaderInterface::class, $h);
        $this->assertSame('If-Unmodified-Since', $h->name());
        $v = $h->values();
        $this->assertInstanceOf(SetInterface::class, $v);
        $this->assertSame(HeaderValueInterface::class, (string) $v->type());
        $this->assertSame($d, $v->current());
        $this->assertSame('If-Unmodified-Since : Fri, 01 Jan 2016 12:12:12 +0200', (string) $h);
    }
}
