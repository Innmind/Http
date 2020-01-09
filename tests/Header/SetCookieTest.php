<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\SetCookie,
    Header,
    Header\Value,
    Header\CookieValue,
    Header\Parameter\Parameter,
    Header\CookieParameter\Secure
};
use Innmind\TimeContinuum\PointInTime\Earth\PointInTime;
use Innmind\Immutable\SetInterface;
use PHPUnit\Framework\TestCase;

class SetCookieTest extends TestCase
{
    public function testInterface()
    {
        $cookie = new SetCookie(
            $value = new CookieValue(
                new Parameter('foo', 'bar'),
                new Secure
            ),
            new CookieValue(
                new Parameter('bar', 'baz')
            )
        );

        $this->assertInstanceOf(Header::class, $cookie);
        $this->assertSame('Set-Cookie', $cookie->name());
        $values = $cookie->values();
        $this->assertInstanceOf(SetInterface::class, $values);
        $this->assertSame(Value::class, (string) $values->type());
        $this->assertSame($value, $values->current());
        $this->assertSame('Set-Cookie: foo=bar; Secure, bar=baz', (string) $cookie);
    }

    public function testOf()
    {
        $cookie = SetCookie::of(
            new Parameter('foo', 'bar'),
            new Parameter('bar', 'baz'),
        );

        $this->assertInstanceOf(SetCookie::class, $cookie);
        $this->assertSame('Set-Cookie: foo=bar; bar=baz', (string) $cookie);
    }
}
