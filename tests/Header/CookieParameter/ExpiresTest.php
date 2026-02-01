<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\CookieParameter;

use Innmind\Http\Header\SetCookie\Expires;
use Innmind\Time\Point;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class ExpiresTest extends TestCase
{
    public function testInterface()
    {
        $expires = Expires::at(Point::at(
            new \DateTimeImmutable('2018-01-01T12:13:14+0200'),
        ));

        $this->assertSame('Expires="Mon, 01 Jan 2018 10:13:14 GMT"', $expires->toParameter()->toString());
    }
}
