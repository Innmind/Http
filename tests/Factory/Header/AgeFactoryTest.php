<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactoryInterface,
    Factory\Header\AgeFactory,
    Header\Age
};
use Innmind\Immutable\StringPrimitive as Str;

class AgeFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            HeaderFactoryInterface::class,
            new AgeFactory
        );
    }

    public function testMake()
    {
        $header = (new AgeFactory)->make(
            new Str('Age'),
            new Str('42')
        );

        $this->assertInstanceOf(Age::class, $header);
        $this->assertSame('Age : 42', (string) $header);
    }
}
