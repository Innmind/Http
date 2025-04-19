<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\Factory,
    Header\Referrer,
};
use Innmind\TimeContinuum\Clock;
use Innmind\Immutable\Str;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class ReferrerFactoryTest extends TestCase
{
    public function testMake()
    {
        $f = Factory::new(Clock::live());

        $h = ($f)(
            Str::of('Referer'),
            Str::of('http://www.w3.org/hypertext/DataSources/Overview.html'),
        );

        $this->assertInstanceOf(Referrer::class, $h);
        $this->assertSame(
            'Referer: http://www.w3.org/hypertext/DataSources/Overview.html',
            $h->toHeader()->toString(),
        );
    }
}
