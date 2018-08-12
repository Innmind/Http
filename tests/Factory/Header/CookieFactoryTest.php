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
        $header = (new CookieFactory)->make(
            new Str('Cookie'),
            new Str('foo=bar;bar=baz; baz="foo"')
        );

        $this->assertInstanceOf(Cookie::class, $header);
        $this->assertSame('Cookie : foo=bar; bar=baz; baz=foo', (string) $header);
        $this->assertSame('Cookie : ', (string) (new CookieFactory)->make(
            new Str('Cookie'),
            new Str('')
        ));
    }

    public function testThrowWhenNotExpectedHeader()
    {
        $this->expectException(DomainException::class);

        (new CookieFactory)->make(
            new Str('foo'),
            new Str('')
        );
    }
}
