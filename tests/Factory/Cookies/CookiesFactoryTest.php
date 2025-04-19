<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Cookies;

use Innmind\Http\{
    Factory\CookiesFactory,
    ServerRequest\Cookies,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class CookiesFactoryTest extends TestCase
{
    public function testMake()
    {
        $f = CookiesFactory::native();

        $c = ($f)();

        $this->assertInstanceOf(Cookies::class, $c);
        $this->assertSame(0, $c->count());
    }
}
