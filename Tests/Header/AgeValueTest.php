<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Header;

use Innmind\Http\Header\{
    AgeValue,
    HeaderValueInterface,
    Quality
};

class AgeValueTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $a = new AgeValue('42');

        $this->assertInstanceOf(HeaderValueInterface::class, $a);
        $this->assertSame('42', (string) $a);

        new AgeValue('0');
    }

    /**
     * @dataProvider invalids
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenInvalidAgeValue($value)
    {
        new AgeValue($value);
    }

    public function invalids(): array
    {
        return [
            ['42.0'],
            ['foo'],
            ['42;q=0.8'],
        ];
    }
}
