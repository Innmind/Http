<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\Factory,
    Header,
    Header\Accept,
};
use Innmind\Time\Clock;
use Innmind\Immutable\Str;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class AcceptFactoryTest extends TestCase
{
    public function testMake()
    {
        $f = Factory::new(Clock::live());

        $h = ($f)(
            Str::of('Accept'),
            Str::of('audio/*; q=0.2; level="1", audio/basic'),
        );

        $this->assertInstanceOf(Accept::class, $h);
        $this->assertSame('Accept: audio/*;q=0.2;level=1, audio/basic', $h->normalize()->toString());
    }

    public function testReturnNothingWhenNotValid()
    {
        $this->assertInstanceOf(
            Header::class,
            Factory::new(Clock::live())(
                Str::of('Accept'),
                Str::of('@'),
            ),
        );
    }
}
