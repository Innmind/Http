<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\HeadersFactory,
    Factory\HeaderFactory,
    Factory\HeadersFactory as HeadersFactoryInterface
};
use Innmind\Immutable\Map;
use PHPUnit\Framework\TestCase;

class HeadersFactoryTest extends TestCase
{
    public function testMake()
    {
        $f = new HeadersFactory(
            $this->createMock(HeaderFactory::class)
        );

        $this->assertInstanceOf(HeadersFactoryInterface::class, $f);
    }
}
