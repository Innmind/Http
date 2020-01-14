<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\TryFactory,
    Factory\HeaderFactory,
    Header
};
use Innmind\Immutable\Str;
use PHPUnit\Framework\TestCase;

class TryFactoryTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            HeaderFactory::class,
            new TryFactory(
                $this->createMock(HeaderFactory::class),
                $this->createMock(HeaderFactory::class)
            )
        );
    }

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
                $expected = $this->createMock(Header::class)
            );
        $fallback = $this->createMock(HeaderFactory::class);
        $fallback
            ->expects($this->never())
            ->method('__invoke');
        $factory = new TryFactory($try, $fallback);

        $this->assertSame($expected, ($factory)($name, $value));
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
            ->will(
                $this->throwException(new \Error)
            );
        $fallback = $this->createMock(HeaderFactory::class);
        $fallback
            ->expects($this->once())
            ->method('__invoke')
            ->with($name, $value)
            ->willReturn(
                $expected = $this->createMock(Header::class)
            );
        $factory = new TryFactory($try, $fallback);

        $this->assertSame($expected, ($factory)($name, $value));
    }
}
