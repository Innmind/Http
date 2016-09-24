<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactoryInterface,
    Factory\Header\AllowFactory,
    Header\Allow
};
use Innmind\Immutable\StringPrimitive as Str;

class AllowFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            HeaderFactoryInterface::class,
            new AllowFactory
        );
    }

    public function testMake()
    {
        $header = (new AllowFactory)->make(
            new Str('Allow'),
            new Str('get, post')
        );

        $this->assertInstanceOf(Allow::class, $header);
        $this->assertSame('Allow : GET, POST', (string) $header);
    }
}
