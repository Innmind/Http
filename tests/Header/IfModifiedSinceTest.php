<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\IfModifiedSince,
    Header,
    Header\Value,
    Header\DateValue
};
use Innmind\TimeContinuum\Earth\PointInTime\PointInTime;
use Innmind\Immutable\Set;
use function Innmind\Immutable\first;
use PHPUnit\Framework\TestCase;

class IfModifiedSinceTest extends TestCase
{
    public function testInterface()
    {
        $h = new IfModifiedSince(
            $d = new DateValue(new PointInTime('2016-01-01 12:12:12+0200'))
        );

        $this->assertInstanceOf(Header::class, $h);
        $this->assertSame('If-Modified-Since', $h->name());
        $v = $h->values();
        $this->assertInstanceOf(Set::class, $v);
        $this->assertSame(Value::class, (string) $v->type());
        $this->assertSame($d, first($v));
        $this->assertSame('If-Modified-Since: Fri, 01 Jan 2016 10:12:12 GMT', $h->toString());
    }

    public function testOf()
    {
        $header = IfModifiedSince::of(new PointInTime('2016-01-01 12:12:12+0200'));

        $this->assertInstanceOf(IfModifiedSince::class, $header);
        $this->assertSame('If-Modified-Since: Fri, 01 Jan 2016 10:12:12 GMT', $header->toString());
    }
}
