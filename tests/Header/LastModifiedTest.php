<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\LastModified,
    Header,
    Header\Value,
    Header\DateValue
};
use Innmind\TimeContinuum\Earth\PointInTime\PointInTime;
use Innmind\Immutable\Set;
use function Innmind\Immutable\first;
use PHPUnit\Framework\TestCase;

class LastModifiedTest extends TestCase
{
    public function testInterface()
    {
        $h = new LastModified(
            $d = new DateValue(new PointInTime('2016-01-01 12:12:12+0200'))
        );

        $this->assertInstanceOf(Header::class, $h);
        $this->assertSame('Last-Modified', $h->name());
        $v = $h->values();
        $this->assertInstanceOf(Set::class, $v);
        $this->assertSame(Value::class, (string) $v->type());
        $this->assertSame($d, first($v));
        $this->assertSame('Last-Modified: Fri, 01 Jan 2016 10:12:12 GMT', $h->toString());
    }

    public function testOf()
    {
        $header = LastModified::of(new PointInTime('2016-01-01 12:12:12+0200'));

        $this->assertInstanceOf(LastModified::class, $header);
        $this->assertSame('Last-Modified: Fri, 01 Jan 2016 10:12:12 GMT', $header->toString());
    }
}
