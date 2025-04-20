<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\SetCookie,
    Header,
    Header\SetCookie\Directive,
    Header\SetCookie\MaxAge,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class SetCookieTest extends TestCase
{
    public function testInterface()
    {
        $cookie = SetCookie::of(
            'foo',
            'bar',
            Directive::secure,
        )->and(SetCookie::of('bar', 'baz'));

        $this->assertInstanceOf(Header\Custom::class, $cookie);
        $this->assertSame('Set-Cookie: foo=bar; Secure, bar=baz', $cookie->normalize()->toString());
    }

    public function testOf()
    {
        $cookie = SetCookie::of(
            'foo',
            'bar',
            MaxAge::expire(),
        );

        $this->assertInstanceOf(SetCookie::class, $cookie);
        $this->assertSame('Set-Cookie: foo=bar; Max-Age=-1', $cookie->normalize()->toString());
    }
}
