<?php
declare(strict_types = 1);

namespace Test\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactoryInterface,
    Factory\Header\ContentLocationFactory,
    Header\ContentLocation
};
use Innmind\Immutable\StringPrimitive as Str;

class ContentLocationFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            HeaderFactoryInterface::class,
            new ContentLocationFactory
        );
    }

    public function testMake()
    {
        $header = (new ContentLocationFactory)->make(
            new Str('Content-Location'),
            new Str('http://example.com')
        );

        $this->assertInstanceOf(ContentLocation::class, $header);
        $this->assertSame('Content-Location : http://example.com/', (string) $header);
    }
}
