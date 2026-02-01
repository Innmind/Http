<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\Factory,
    Header,
    Header\AcceptEncoding,
};
use Innmind\Time\Clock;
use Innmind\Immutable\Str;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class AcceptEncodingFactoryTest extends TestCase
{
    public function testMake()
    {
        $f = Factory::new(Clock::live());

        $h = ($f)(
            Str::of('Accept-Encoding'),
            Str::of('gzip, identity; q=0.5, *;q=0'),
        );

        $this->assertInstanceOf(AcceptEncoding::class, $h);
        $this->assertSame(
            'Accept-Encoding: gzip;q=1, identity;q=0.5, *;q=0',
            $h->normalize()->toString(),
        );
    }

    public function testReturnNothingWhenNotValid()
    {
        $this->assertInstanceOf(
            Header::class,
            Factory::new(Clock::live())(
                Str::of('Accept-Encoding'),
                Str::of('@'),
            ),
        );
    }
}
