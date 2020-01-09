<?php
declare(strict_types = 1);

namespace Test\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory,
    Factory\Header\LocationFactory,
    Header\Location
};
use Innmind\Immutable\Str;
use PHPUnit\Framework\TestCase;

class LocationFactoryTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            HeaderFactory::class,
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
        $this->assertSame('Location: http://example.com/', $header->toString());
    }

    /**
     * @expectedException Innmind\Http\Exception\DomainException
     */
    public function testThrowWhenNotExpectedHeader()
    {
        (new LocationFactory)->make(
            new Str('foo'),
            new Str('')
        );
    }
}
