<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory;

use Innmind\Http\{
    Factory\CookiesFactory,
    Factory\CookiesFactoryInterface,
    Message\CookiesInterface
};
use Innmind\Immutable\Map;
use PHPUnit\Framework\TestCase;

class CookiesFactoryTest extends TestCase
{
    public function testMake()
    {
        $f = new CookiesFactory;

        $this->assertInstanceOf(CookiesFactoryInterface::class, $f);

        $c = $f->make();

        $this->assertInstanceOf(CookiesInterface::class, $c);
        $this->assertSame(0, $c->count());
    }
}
