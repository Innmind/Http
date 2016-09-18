<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\{
    AgeValue,
    HeaderValueInterface
};

class AgeValueTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $a = new AgeValue(42);

        $this->assertInstanceOf(HeaderValueInterface::class, $a);
        $this->assertSame('42', (string) $a);

        new AgeValue(0);
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenInvalidAgeValue()
    {
        new AgeValue(-1);
    }
}
