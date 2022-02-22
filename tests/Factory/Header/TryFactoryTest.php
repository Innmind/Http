<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\TryFactory,
    Factory\HeaderFactory,
    Header
};
use Innmind\Immutable\{
    Str,
    Maybe,
};
use PHPUnit\Framework\TestCase;

class TryFactoryTest extends TestCase
{
    public function testMake()
    {
        $name = Str::of('foo');
        $value = Str::of('bar');
        $try = $this->createMock(HeaderFactory::class);
        $try
            ->expects($this->once())
            ->method('__invoke')
            ->with($name, $value)
            ->willReturn(
                Maybe::just($expected = $this->createMock(Header::class)),
            );
        $factory = new TryFactory($try);

        $this->assertEquals($expected, ($factory)($name, $value));
    }

    public function testMakeViaFallback()
    {
        $name = Str::of('foo');
        $value = Str::of('bar');
        $try = $this->createMock(HeaderFactory::class);
        $try
            ->expects($this->once())
            ->method('__invoke')
            ->with($name, $value)
            ->willReturn(Maybe::nothing());
        $expected = $this->createMock(Header::class);
        $fallback = static fn() => $expected;
        $factory = new TryFactory($try, $fallback);

        $this->assertSame($expected, ($factory)($name, $value));
    }
}
