<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\LastModified,
    Header,
    Header\DateValue
};
use Innmind\TimeContinuum\PointInTime;
use Innmind\Immutable\Set;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class LastModifiedTest extends TestCase
{
    public function testInterface()
    {
        $h = new LastModified(
            $d = new DateValue(PointInTime::at(
                new \DateTimeImmutable('2016-01-01 12:12:12+0200'),
            )),
        );

        $this->assertInstanceOf(Header::class, $h);
        $this->assertSame('Last-Modified', $h->name());
        $v = $h->values();
        $this->assertInstanceOf(Set::class, $v);
        $this->assertSame($d, $v->find(static fn() => true)->match(
            static fn($first) => $first,
            static fn() => null,
        ));
        $this->assertSame('Last-Modified: Fri, 01 Jan 2016 10:12:12 GMT', $h->toString());
        $this->assertSame($d->date(), $h->date());
    }

    public function testOf()
    {
        $header = LastModified::of(PointInTime::at(
            new \DateTimeImmutable('2016-01-01 12:12:12+0200'),
        ));

        $this->assertInstanceOf(LastModified::class, $header);
        $this->assertSame('Last-Modified: Fri, 01 Jan 2016 10:12:12 GMT', $header->toString());
    }
}
