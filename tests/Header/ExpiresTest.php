<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\Expires,
    Header,
};
use Innmind\Time\Point;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class ExpiresTest extends TestCase
{
    public function testInterface()
    {
        $h = Expires::of(
            Point::at(
                new \DateTimeImmutable('2016-01-01 12:12:12+0200'),
            ),
        );

        $this->assertInstanceOf(Header\Custom::class, $h);
        $this->assertSame('Expires: Fri, 01 Jan 2016 10:12:12 GMT', $h->normalize()->toString());
    }

    public function testOf()
    {
        $header = Expires::of(Point::at(
            new \DateTimeImmutable('2016-01-01 12:12:12+0200'),
        ));

        $this->assertInstanceOf(Header\Custom::class, $header);
        $this->assertSame('Expires: Fri, 01 Jan 2016 10:12:12 GMT', $header->normalize()->toString());
    }
}
