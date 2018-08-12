<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\CookieParameter;

use Innmind\Http\Header\{
    CookieParameter\Expires,
    Parameter
};
use Innmind\TimeContinuum\PointInTime\Earth\PointInTime;
use PHPUnit\Framework\TestCase;

class ExpiresTest extends TestCase
{
    public function testInterface()
    {
        $expires = new Expires(new PointInTime('2018-01-01T12:13:14+0200'));

        $this->assertInstanceOf(Parameter::class, $expires);
        $this->assertSame('Expires="Mon, 01 Jan 2018 12:13:14 +0200"', (string) $expires);
    }
}
