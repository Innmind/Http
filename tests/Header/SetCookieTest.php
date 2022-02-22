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
use Innmind\Immutable\Set;
use PHPUnit\Framework\TestCase;

class SetCookieTest extends TestCase
{
    public function testInterface()
    {
        $cookie = new SetCookie(
            $value = new CookieValue(
                new Parameter('foo', 'bar'),
                new Secure,
            ),
            new CookieValue(
                new Parameter('bar', 'baz'),
            ),
        );

        $this->assertInstanceOf(Header::class, $cookie);
        $this->assertSame('Set-Cookie', $cookie->name());
        $values = $cookie->values();
        $this->assertInstanceOf(Set::class, $values);
        $this->assertSame($value, $values->find(static fn() => true)->match(
            static fn($first) => $first,
            static fn() => null,
        ));
        $this->assertSame('Set-Cookie: foo=bar; Secure, bar=baz', $cookie->toString());
    }

    public function testOf()
    {
        $cookie = SetCookie::of(
            new Parameter('foo', 'bar'),
            new Parameter('bar', 'baz'),
        );

        $this->assertInstanceOf(SetCookie::class, $cookie);
        $this->assertSame('Set-Cookie: foo=bar; bar=baz', $cookie->toString());
    }
}
