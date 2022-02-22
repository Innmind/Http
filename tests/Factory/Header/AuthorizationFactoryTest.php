<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\AuthorizationFactory,
    Factory\HeaderFactory,
    Header\Authorization,
};
use Innmind\Immutable\Str;
use PHPUnit\Framework\TestCase;

class AuthorizationFactoryTest extends TestCase
{
    public function testMake()
    {
        $f = new AuthorizationFactory;

        $this->assertInstanceOf(HeaderFactory::class, $f);

        $h = ($f)(
            Str::of('Authorization'),
            Str::of('Basic realm="WallyWorld"'),
        )->match(
            static fn($header) => $header,
            static fn() => null,
        );

        $this->assertInstanceOf(Authorization::class, $h);
        $this->assertSame(
            'Authorization: "Basic" realm="WallyWorld"',
            $h->toString(),
        );
    }

    public function testReturnNothingWhenNotExpectedHeader()
    {
        $this->assertNull((new AuthorizationFactory)(
            Str::of('foo'),
            Str::of(''),
        )->match(
            static fn($header) => $header,
            static fn() => null,
        ));
    }

    public function testReturnNothingWhenNotValid()
    {
        $this->assertNull((new AuthorizationFactory)(
            Str::of('Authorization'),
            Str::of('@'),
        )->match(
            static fn($header) => $header,
            static fn() => null,
        ));
    }
}
