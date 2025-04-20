<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\Factory,
    Header,
    Header\IfUnmodifiedSince,
};
use Innmind\TimeContinuum\Clock;
use Innmind\Immutable\Str;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class IfUnmodifiedSinceFactoryTest extends TestCase
{
    public function testMake()
    {
        $f = Factory::new(Clock::live());

        $h = ($f)(
            Str::of('If-Unmodified-Since'),
            Str::of('Tue, 15 Nov 1994 08:12:31 GMT'),
        );

        $this->assertInstanceOf(IfUnmodifiedSince::class, $h);
        $this->assertSame(
            'If-Unmodified-Since: Tue, 15 Nov 1994 08:12:31 GMT',
            $h->normalize()->toString(),
        );
    }

    public function testReturnNothingWhenNotOfExpectedFormat()
    {
        $this->assertInstanceOf(
            Header::class,
            Factory::new(Clock::live())(
                Str::of('If-Unmodified-Since'),
                Str::of('2020-01-01'),
            ),
        );
    }
}
