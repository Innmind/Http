<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\DelegationFactory,
    Factory\HeaderFactory,
    Header
};
use Innmind\Immutable\{
    Map,
    Str
};
use PHPUnit\Framework\TestCase;

class DelegationFactoryTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            HeaderFactory::class,
            new DelegationFactory(
                new Map('string', HeaderFactory::class)
            )
        );
    }

    /**
     * @expectedException TypeError
     * @expectedExceptionMessage Argument 1 must be of type MapInterface<string, Innmind\Http\Factory\HeaderFactory>
     */
    public function testThrowWhenInvalidMap()
    {
        new DelegationFactory(new Map('string', 'callable'));
    }

    public function testMake()
    {
        $name = new Str('X-Foo');
        $value = new Str('bar');
        $mock = $this->createMock(HeaderFactory::class);
        $mock
            ->expects($this->once())
            ->method('__invoke')
            ->with($name, $value)
            ->willReturn(
                $expected = $this->createMock(Header::class)
            );
        $neverToBeCalled = $this->createMock(HeaderFactory::class);
        $neverToBeCalled
            ->expects($this->never())
            ->method('__invoke');
        $factory = new DelegationFactory(
            (new Map('string', HeaderFactory::class))
                ->put('x-foo', $mock)
                ->put('foo', $neverToBeCalled)
        );

        $header = ($factory)($name, $value);
    }
}
