<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\ExpiresFactory,
    Factory\HeaderFactory,
    Header\Expires,
};
use Innmind\TimeContinuum\Earth\Clock;
use Innmind\Immutable\Str;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class ExpiresFactoryTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            HeaderFactory::class,
            new ExpiresFactory(new Clock),
        );
    }

    public function testMake()
    {
        $header = (new ExpiresFactory(new Clock))(
            Str::of('Expires'),
            Str::of('Tue, 15 Nov 1994 08:12:31 GMT'),
        )->match(
            static fn($header) => $header,
            static fn() => null,
        );

        $this->assertInstanceOf(Expires::class, $header);
        $this->assertSame(
            'Expires: Tue, 15 Nov 1994 08:12:31 GMT',
            $header->toString(),
        );
    }

    public function testReturnNothingWhenNotExpectedHeader()
    {
        $this->assertNull((new ExpiresFactory(new Clock))(
            Str::of('foo'),
            Str::of(''),
        )->match(
            static fn($header) => $header,
            static fn() => null,
        ));
    }

    public function testReturnNothingWhenNotOfExpectedFormat()
    {
        $this->assertNull((new ExpiresFactory(new Clock))(
            Str::of('Expires'),
            Str::of('2020-01-01'),
        )->match(
            static fn($header) => $header,
            static fn() => null,
        ));
    }
}
