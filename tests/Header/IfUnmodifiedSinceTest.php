<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\IfUnmodifiedSince,
    Header,
};
use Innmind\TimeContinuum\PointInTime;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class IfUnmodifiedSinceTest extends TestCase
{
    public function testInterface()
    {
        $h = IfUnmodifiedSince::of(
            PointInTime::at(
                new \DateTimeImmutable('2016-01-01 12:12:12+0200'),
            ),
        );

        $this->assertInstanceOf(Header\Provider::class, $h);
        $this->assertSame('If-Unmodified-Since: Fri, 01 Jan 2016 10:12:12 GMT', $h->toHeader()->toString());
    }

    public function testOf()
    {
        $header = IfUnmodifiedSince::of(PointInTime::at(
            new \DateTimeImmutable('2016-01-01 12:12:12+0200'),
        ));

        $this->assertInstanceOf(IfUnmodifiedSince::class, $header);
        $this->assertSame('If-Unmodified-Since: Fri, 01 Jan 2016 10:12:12 GMT', $header->toHeader()->toString());
    }
}
