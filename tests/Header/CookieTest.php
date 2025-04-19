<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\Cookie,
    Header,
    Header\CookieValue,
    Header\Parameter\Parameter
};
use Innmind\Immutable\Sequence;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class CookieTest extends TestCase
{
    public function testInterface()
    {
        $cookie = new Cookie(
            $value = new CookieValue(new Parameter('foo', 'bar')),
        );

        $this->assertInstanceOf(Header::class, $cookie);
        $this->assertSame('Cookie', $cookie->name());
        $values = $cookie->values();
        $this->assertInstanceOf(Sequence::class, $values);
        $this->assertSame($value, $values->find(static fn() => true)->match(
            static fn($first) => $first,
            static fn() => null,
        ));
        $this->assertSame('Cookie: foo=bar', $cookie->toString());
        $this->assertSame($value->parameters(), $cookie->parameters());
    }

    public function testOf()
    {
        $cookie = Cookie::of(new Parameter('foo', 'bar'));

        $this->assertInstanceOf(Cookie::class, $cookie);
        $this->assertSame('Cookie: foo=bar', $cookie->toString());
    }
}
