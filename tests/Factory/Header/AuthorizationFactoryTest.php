<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\Factory,
    Header,
    Header\Authorization,
};
use Innmind\Time\Clock;
use Innmind\Immutable\Str;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class AuthorizationFactoryTest extends TestCase
{
    public function testMake()
    {
        $f = Factory::new(Clock::live());

        $h = ($f)(
            Str::of('Authorization'),
            Str::of('Basic realm="WallyWorld"'),
        );

        $this->assertInstanceOf(Authorization::class, $h);
        $this->assertSame(
            'Authorization: Basic realm="WallyWorld"',
            $h->normalize()->toString(),
        );
    }

    public function testReturnNothingWhenNotValid()
    {
        $this->assertInstanceOf(
            Header::class,
            Factory::new(Clock::live())(
                Str::of('Authorization'),
                Str::of('@'),
            ),
        );
    }
}
