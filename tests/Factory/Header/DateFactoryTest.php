<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\Factory,
    Header,
    Header\Date,
};
use Innmind\TimeContinuum\Clock;
use Innmind\Immutable\Str;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class DateFactoryTest extends TestCase
{
    public function testMake()
    {
        $f = Factory::new(Clock::live());

        $h = ($f)(
            Str::of('Date'),
            Str::of('Tue, 15 Nov 1994 08:12:31 GMT'),
        );

        $this->assertInstanceOf(Date::class, $h);
        $this->assertSame(
            'Date: Tue, 15 Nov 1994 08:12:31 GMT',
            $h->toString(),
        );
    }

    public function testReturnNothingWhenNotOFExpectedFormat()
    {
        $this->assertInstanceOf(
            Header::class,
            Factory::new(Clock::live())(
                Str::of('Date'),
                Str::of('2020-01-01'),
            ),
        );
    }
}
