<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\Factory,
    Header,
    Header\AcceptCharset,
};
use Innmind\TimeContinuum\Clock;
use Innmind\Immutable\Str;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class AcceptCharsetFactoryTest extends TestCase
{
    public function testMake()
    {
        $f = Factory::new(Clock::live());

        $h = ($f)(
            Str::of('Accept-Charset'),
            Str::of('iso-8859-5, unicode-1-1;q=0.8'),
        );

        $this->assertInstanceOf(AcceptCharset::class, $h);
        $this->assertSame(
            'Accept-Charset: iso-8859-5;q=1, unicode-1-1;q=0.8',
            $h->normalize()->toString(),
        );
    }

    public function testReturnNothingWhenInvalidValue()
    {
        $this->assertInstanceOf(
            Header::class,
            Factory::new(Clock::live())(
                Str::of('Accept-Charset'),
                Str::of('@'),
            ),
        );
    }
}
