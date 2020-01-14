<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\AuthorizationFactory,
    Factory\HeaderFactory,
    Header\Authorization,
    Exception\DomainException,
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
        );

        $this->assertInstanceOf(Authorization::class, $h);
        $this->assertSame(
            'Authorization: "Basic" realm="WallyWorld"',
            $h->toString(),
        );
    }

    public function testThrowWhenNotExpectedHeader()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('foo');

        (new AuthorizationFactory)(
            Str::of('foo'),
            Str::of(''),
        );
    }

    public function testThrowWhenNotValid()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Authorization');

        (new AuthorizationFactory)(
            Str::of('Authorization'),
            Str::of('@'),
        );
    }
}
