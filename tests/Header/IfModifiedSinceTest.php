<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\IfModifiedSince,
    Header,
};
use Innmind\TimeContinuum\PointInTime;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class IfModifiedSinceTest extends TestCase
{
    public function testInterface()
    {
        $h = IfModifiedSince::of(
            PointInTime::at(
                new \DateTimeImmutable('2016-01-01 12:12:12+0200'),
            ),
        );

        $this->assertInstanceOf(Header\Provider::class, $h);
        $this->assertSame('If-Modified-Since: Fri, 01 Jan 2016 10:12:12 GMT', $h->toHeader()->toString());
    }

    public function testOf()
    {
        $header = IfModifiedSince::of(PointInTime::at(
            new \DateTimeImmutable('2016-01-01 12:12:12+0200'),
        ));

        $this->assertInstanceOf(IfModifiedSince::class, $header);
        $this->assertSame('If-Modified-Since: Fri, 01 Jan 2016 10:12:12 GMT', $header->toHeader()->toString());
    }
}
