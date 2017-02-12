<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\DelegationFactory,
    Factory\HeaderFactoryInterface,
    Header\HeaderInterface
};
use Innmind\Immutable\{
    Map,
    StringPrimitive as Str
};
use PHPUnit\Framework\TestCase;

class DelegationFactoryTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            HeaderFactoryInterface::class,
            new DelegationFactory(
                new Map('string', HeaderFactoryInterface::class)
            )
        );
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenInvalidMap()
    {
        new DelegationFactory(new Map('string', 'callable'));
    }

    public function testMake()
    {
        $name = new Str('X-Foo');
        $value = new Str('bar');
        $mock = $this->createMock(HeaderFactoryInterface::class);
        $mock
            ->expects($this->once())
            ->method('make')
            ->with($name, $value)
            ->willReturn(
                $expected = $this->createMock(HeaderInterface::class)
            );
        $neverToBeCalled = $this->createMock(HeaderFactoryInterface::class);
        $neverToBeCalled
            ->expects($this->never())
            ->method('make');
        $factory = new DelegationFactory(
            (new Map('string', HeaderFactoryInterface::class))
                ->put('x-foo', $mock)
                ->put('foo', $neverToBeCalled)
        );

        $header = $factory->make($name, $value);
    }
}
