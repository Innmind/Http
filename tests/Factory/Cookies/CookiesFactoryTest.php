<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Cookies;

use Innmind\Http\{
    Factory\Cookies\CookiesFactory,
    Factory\CookiesFactory as CookiesFactoryInterface,
    Message\Cookies
};
use Innmind\Immutable\Map;
use PHPUnit\Framework\TestCase;

class CookiesFactoryTest extends TestCase
{
    public function testMake()
    {
        $f = new CookiesFactory;

        $this->assertInstanceOf(CookiesFactoryInterface::class, $f);

        $c = ($f)();

        $this->assertInstanceOf(Cookies::class, $c);
        $this->assertSame(0, $c->count());
    }
}
