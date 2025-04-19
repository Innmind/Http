<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\Cookie,
    Header,
    Header\CookieValue,
    Header\Parameter\Parameter
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class CookieTest extends TestCase
{
    public function testInterface()
    {
        $cookie = new Cookie(
            $value = new CookieValue(new Parameter('foo', 'bar')),
        );

        $this->assertInstanceOf(Header\Provider::class, $cookie);
        $this->assertSame('Cookie: foo=bar', $cookie->toHeader()->toString());
    }

    public function testOf()
    {
        $cookie = Cookie::of(new Parameter('foo', 'bar'));

        $this->assertInstanceOf(Cookie::class, $cookie);
        $this->assertSame('Cookie: foo=bar', $cookie->toHeader()->toString());
    }
}
