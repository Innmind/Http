<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\IfUnmodifiedSince,
    Header,
    Header\Value,
    Header\DateValue
};
use Innmind\TimeContinuum\Earth\PointInTime\PointInTime;
use Innmind\Immutable\Set;
use PHPUnit\Framework\TestCase;

class IfUnmodifiedSinceTest extends TestCase
{
    public function testInterface()
    {
        $h = new IfUnmodifiedSince(
            $d = new DateValue(new PointInTime('2016-01-01 12:12:12+0200'))
        );

        $this->assertInstanceOf(Header::class, $h);
        $this->assertSame('If-Unmodified-Since', $h->name());
        $v = $h->values();
        $this->assertInstanceOf(Set::class, $v);
        $this->assertSame($d, $v->find(static fn() => true)->match(
            static fn($first) => $first,
            static fn() => null,
        ));
        $this->assertSame('If-Unmodified-Since: Fri, 01 Jan 2016 10:12:12 GMT', $h->toString());
    }

    public function testOf()
    {
        $header = IfUnmodifiedSince::of(new PointInTime('2016-01-01 12:12:12+0200'));

        $this->assertInstanceOf(IfUnmodifiedSince::class, $header);
        $this->assertSame('If-Unmodified-Since: Fri, 01 Jan 2016 10:12:12 GMT', $header->toString());
    }
}
