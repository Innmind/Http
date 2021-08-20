<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory,
    Factory\Header\CookieFactory,
    Header\Cookie,
};
use Innmind\Immutable\Str;
use PHPUnit\Framework\TestCase;

class CookieFactoryTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            HeaderFactory::class,
            new CookieFactory
        );
    }

    public function testMake()
    {
        $header = (new CookieFactory)(
            Str::of('Cookie'),
            Str::of('foo=bar;bar=baz; baz="foo"'),
        )->match(
            static fn($header) => $header,
            static fn() => null,
        );

        $this->assertInstanceOf(Cookie::class, $header);
        $this->assertSame('Cookie: foo=bar; bar=baz; baz=foo', $header->toString());
        $this->assertSame(
            'Cookie: ',
            (new CookieFactory)(Str::of('Cookie'), Str::of(''))->match(
                static fn($cookie) => $cookie->toString(),
                static fn() => null,
            ),
        );
    }

    public function testReturnNothingWhenNotExpectedHeader()
    {
        $this->assertNull((new CookieFactory)(
            Str::of('foo'),
            Str::of(''),
        )->match(
            static fn($header) => $header,
            static fn() => null,
        ));
    }
}
