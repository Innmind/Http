<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\Cookie,
    Header,
    Header\Value,
    Header\CookieValue,
    Header\Parameter\Parameter
};
use Innmind\TimeContinuum\PointInTime\Earth\PointInTime;
use Innmind\Immutable\SetInterface;
use PHPUnit\Framework\TestCase;

class CookieTest extends TestCase
{
    public function testInterface()
    {
        $cookie = new Cookie(
            $value = new CookieValue(new Parameter('foo', 'bar'))
        );

        $this->assertInstanceOf(Header::class, $cookie);
        $this->assertSame('Cookie', $cookie->name());
        $values = $cookie->values();
        $this->assertInstanceOf(SetInterface::class, $values);
        $this->assertSame(Value::class, (string) $values->type());
        $this->assertSame($value, $values->current());
        $this->assertSame('Cookie: foo=bar', $cookie->toString());
    }

    public function testOf()
    {
        $cookie = Cookie::of(new Parameter('foo', 'bar'));

        $this->assertInstanceOf(Cookie::class, $cookie);
        $this->assertSame('Cookie: foo=bar', $cookie->toString());
    }
}
