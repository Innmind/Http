<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\Factory,
    Header,
    Header\AcceptLanguage,
};
use Innmind\TimeContinuum\Clock;
use Innmind\Immutable\Str;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class AcceptLanguageFactoryTest extends TestCase
{
    public function testMake()
    {
        $f = Factory::new(Clock::live());

        $h = ($f)(
            Str::of('Accept-Language'),
            Str::of('da, en-gb;q=0.8, en;q=0.7'),
        );

        $this->assertInstanceOf(AcceptLanguage::class, $h);
        $this->assertSame(
            'Accept-Language: da;q=1, en-gb;q=0.8, en;q=0.7',
            $h->toHeader()->toString(),
        );
    }

    public function testReturnNothingWhenNotValid()
    {
        $this->assertInstanceOf(
            Header::class,
            Factory::new(Clock::live())(
                Str::of('Accept-Language'),
                Str::of('@'),
            ),
        );
    }
}
