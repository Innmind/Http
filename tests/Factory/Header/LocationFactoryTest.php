<?php
declare(strict_types = 1);

namespace Test\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactoryInterface,
    Factory\Header\LocationFactory,
    Header\Location
};
use Innmind\Immutable\StringPrimitive as Str;

class LocationFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            HeaderFactoryInterface::class,
            new LocationFactory
        );
    }

    public function testMake()
    {
        $header = (new LocationFactory)->make(
            new Str('Location'),
            new Str('http://example.com')
        );

        $this->assertInstanceOf(Location::class, $header);
        $this->assertSame('Location : http://example.com/', (string) $header);
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenNotExpectedHeader()
    {
        (new LocationFactory)->make(
            new Str('foo'),
            new Str('')
        );
    }
}
