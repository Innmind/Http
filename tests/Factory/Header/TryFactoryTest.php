<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\Factory,
    Header,
    Header\Allow,
    Header\Age,
};
use Innmind\TimeContinuum\Clock;
use Innmind\Immutable\Str;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class TryFactoryTest extends TestCase
{
    public function testMake()
    {
        $name = Str::of('Age');
        $value = Str::of('42');
        $factory = Factory::new(Clock::live());

        $this->assertInstanceOf(Age::class, ($factory)($name, $value));
    }

    public function testMakeViaFallback()
    {
        $name = Str::of('Allow');
        $value = Str::of('PUT');
        $factory = Factory::new(Clock::live());

        $this->assertInstanceOf(Allow::class, ($factory)($name, $value));
    }

    public function testUnknownHeader()
    {
        $header = Factory::new(Clock::live())(
            Str::of('X-Foo'),
            Str::of('bar'),
        );

        $this->assertInstanceOf(Header::class, $header);
        $this->assertSame('X-Foo: bar', $header->toString());
    }
}
