<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\TryFactory,
    Factory\HeaderFactoryInterface,
    Header\HeaderInterface
};
use Innmind\Immutable\StringPrimitive as Str;

class TryFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            HeaderFactoryInterface::class,
            new TryFactory(
                $this->createMock(HeaderFactoryInterface::class),
                $this->createMock(HeaderFactoryInterface::class)
            )
        );
    }

    public function testMake()
    {
        $name = new Str('foo');
        $value = new Str('bar');
        $try = $this->createMock(HeaderFactoryInterface::class);
        $try
            ->expects($this->once())
            ->method('make')
            ->with($name, $value)
            ->willReturn(
                $expected = $this->createMock(HeaderInterface::class)
            );
        $fallback = $this->createMock(HeaderFactoryInterface::class);
        $fallback
            ->expects($this->never())
            ->method('make');
        $factory = new TryFactory($try, $fallback);

        $this->assertSame($expected, $factory->make($name, $value));
    }

    public function testMakeViaFallback()
    {
        $name = new Str('foo');
        $value = new Str('bar');
        $try = $this->createMock(HeaderFactoryInterface::class);
        $try
            ->expects($this->once())
            ->method('make')
            ->with($name, $value)
            ->will(
                $this->throwException(new \Exception)
            );
        $fallback = $this->createMock(HeaderFactoryInterface::class);
        $fallback
            ->expects($this->once())
            ->method('make')
            ->with($name, $value)
            ->willReturn(
                $expected = $this->createMock(HeaderInterface::class)
            );
        $factory = new TryFactory($try, $fallback);

        $this->assertSame($expected, $factory->make($name, $value));
    }
}
