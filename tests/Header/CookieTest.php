<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\Cookie,
    Header,
    Header\Parameter\Parameter,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class CookieTest extends TestCase
{
    public function testInterface()
    {
        $cookie = Cookie::of(
            new Parameter('foo', 'bar'),
        );

        $this->assertInstanceOf(Cookie::class, $cookie);
        $this->assertInstanceOf(Header\Custom::class, $cookie);
        $this->assertSame('Cookie: foo=bar', $cookie->normalize()->toString());
    }
}
