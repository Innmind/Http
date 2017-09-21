<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory,
    Factory\Header\AllowFactory,
    Header\Allow
};
use Innmind\Immutable\Str;
use PHPUnit\Framework\TestCase;

class AllowFactoryTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            HeaderFactory::class,
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

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenNotExpectedHeader()
    {
        (new AllowFactory)->make(
            new Str('foo'),
            new Str('')
        );
    }
}
