<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\SetCookie,
    Header,
    Header\Parameter\Parameter,
    Header\CookieParameter\Secure
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class SetCookieTest extends TestCase
{
    public function testInterface()
    {
        $cookie = SetCookie::of(
            'foo',
            'bar',
            new Secure,
        )->and(SetCookie::of('bar', 'baz'));

        $this->assertInstanceOf(Header\Custom::class, $cookie);
        $this->assertSame('Set-Cookie: foo=bar; Secure, bar=baz', $cookie->normalize()->toString());
    }

    public function testOf()
    {
        $cookie = SetCookie::of(
            'foo',
            'bar',
            new Parameter('bar', 'baz'),
        );

        $this->assertInstanceOf(SetCookie::class, $cookie);
        $this->assertSame('Set-Cookie: foo=bar; bar=baz', $cookie->normalize()->toString());
    }
}
