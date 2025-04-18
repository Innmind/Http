<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\CookieParameter;

use Innmind\Http\Header\{
    CookieParameter\Expires,
    Parameter
};
use Innmind\TimeContinuum\Earth\PointInTime\PointInTime;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class ExpiresTest extends TestCase
{
    public function testInterface()
    {
        $expires = new Expires(new PointInTime('2018-01-01T12:13:14+0200'));

        $this->assertInstanceOf(Parameter::class, $expires);
        $this->assertSame('Expires="Mon, 01 Jan 2018 10:13:14 GMT"', $expires->toString());
    }
}
