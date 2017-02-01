<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory;

use Innmind\Http\{
    Factory\HeadersFactory,
    Factory\HeaderFactoryInterface,
    Factory\HeadersFactoryInterface
};
use Innmind\Immutable\Map;

class HeadersFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testMake()
    {
        $f = new HeadersFactory(
            $this->createMock(HeaderFactoryInterface::class)
        );

        $this->assertInstanceOf(HeadersFactoryInterface::class, $f);
    }
}
