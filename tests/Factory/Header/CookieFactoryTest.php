<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory,
    Factory\Header\CookieFactory,
    Header\Cookie,
    Exception\DomainException
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
        );

        $this->assertInstanceOf(Cookie::class, $header);
        $this->assertSame('Cookie: foo=bar; bar=baz; baz=foo', $header->toString());
        $this->assertSame('Cookie: ', (new CookieFactory)(
            Str::of('Cookie'),
            Str::of(''),
        )->toString());
    }

    public function testThrowWhenNotExpectedHeader()
    {
        $this->expectException(DomainException::class);

        (new CookieFactory)(
            Str::of('foo'),
            Str::of(''),
        );
    }
}
