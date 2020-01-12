<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\HeaderFactory,
    Factory\HeaderFactory as HeaderFactoryInterface,
    Header
};
use Innmind\Immutable\Str;
use PHPUnit\Framework\TestCase;

class HeaderFactoryTest extends TestCase
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

        $header = ($factory)(
            Str::of('X-Foo'),
            Str::of('bar')
        );

        $this->assertInstanceOf(Header::class, $header);
        $this->assertSame('X-Foo: bar', $header->toString());
    }
}
