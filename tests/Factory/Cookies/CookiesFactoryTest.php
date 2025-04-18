<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Cookies;

use Innmind\Http\{
    Factory\Cookies\CookiesFactory,
    Factory\CookiesFactory as CookiesFactoryInterface,
    ServerRequest\Cookies,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class CookiesFactoryTest extends TestCase
{
    public function testMake()
    {
        $f = CookiesFactory::default();

        $this->assertInstanceOf(CookiesFactoryInterface::class, $f);

        $c = ($f)();

        $this->assertInstanceOf(Cookies::class, $c);
        $this->assertSame(0, $c->count());
    }
}
