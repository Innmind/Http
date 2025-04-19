<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\DateFactory,
    Header\Date,
};
use Innmind\TimeContinuum\Clock;
use Innmind\Immutable\Str;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class DateFactoryTest extends TestCase
{
    public function testMake()
    {
        $f = new DateFactory(Clock::live());

        $h = ($f)(
            Str::of('Date'),
            Str::of('Tue, 15 Nov 1994 08:12:31 GMT'),
        )->match(
            static fn($header) => $header,
            static fn() => null,
        );

        $this->assertInstanceOf(Date::class, $h);
        $this->assertSame(
            'Date: Tue, 15 Nov 1994 08:12:31 GMT',
            $h->toString(),
        );
    }

    public function testReturnNothingWhenNotExpectedHeader()
    {
        $this->assertNull((new DateFactory(Clock::live()))(
            Str::of('foo'),
            Str::of(''),
        )->match(
            static fn($header) => $header,
            static fn() => null,
        ));
    }

    public function testReturnNothingWhenNotOFExpectedFormat()
    {
        $this->assertNull((new DateFactory(Clock::live()))(
            Str::of('Date'),
            Str::of('2020-01-01'),
        )->match(
            static fn($header) => $header,
            static fn() => null,
        ));
    }
}
