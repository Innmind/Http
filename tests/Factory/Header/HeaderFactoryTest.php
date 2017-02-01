<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\HeaderFactory,
    Factory\HeaderFactoryInterface,
    Header\HeaderInterface
};
use Innmind\Immutable\StringPrimitive as Str;

class HeaderFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            HeaderFactoryInterface::class,
            new HeaderFactory
        );
    }

    public function testMake()
    {
        $factory = new HeaderFactory;

        $header = $factory->make(
            new Str('X-Foo'),
            new Str('bar')
        );

        $this->assertInstanceOf(HeaderInterface::class, $header);
        $this->assertSame('X-Foo : bar', (string) $header);
    }
}
