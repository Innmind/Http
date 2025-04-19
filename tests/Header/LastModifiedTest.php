<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\LastModified,
    Header,
};
use Innmind\TimeContinuum\PointInTime;
use Innmind\Immutable\Sequence;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class LastModifiedTest extends TestCase
{
    public function testInterface()
    {
        $h = LastModified::of(
            PointInTime::at(
                new \DateTimeImmutable('2016-01-01 12:12:12+0200'),
            ),
        );

        $this->assertInstanceOf(Header::class, $h);
        $this->assertSame('Last-Modified', $h->name());
        $v = $h->values();
        $this->assertInstanceOf(Sequence::class, $v);
        $this->assertSame('Last-Modified: Fri, 01 Jan 2016 10:12:12 GMT', $h->toString());
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
