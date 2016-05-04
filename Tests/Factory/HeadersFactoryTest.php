<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Factory;

use Innmind\Http\{
    Factory\HeadersFactory,
    Factory\HeaderFactoryInterface,
    Factory\HeadersFactoryInterface,
    Factory\Header\DefaultFactory
};
use Innmind\Immutable\Map;

class HeadersFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testMake()
    {
        $f = new HeadersFactory(
            new DefaultFactory(
                new Map('string', HeaderFactoryInterface::class)
            )
        );

        $this->assertInstanceOf(HeadersFactoryInterface::class, $f);
    }
}
