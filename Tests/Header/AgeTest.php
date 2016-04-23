<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Header;

use Innmind\Http\Header\{
    Age,
    HeaderInterface,
    HeaderValueInterface,
    HeaderValue,
    AgeValue
};
use Innmind\Immutable\Set;

class AgeTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $h = new Age(
            $v = (new Set(HeaderValueInterface::class))
                ->add(new AgeValue(42))
        );

        $this->assertInstanceOf(HeaderInterface::class, $h);
        $this->assertSame('Age', $h->name());
        $this->assertSame($v, $h->values());
        $this->assertSame('Age : 42', (string) $h);
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testRangeThrowWhenBuildingWithoutAgeValue()
    {
        new Age(
            (new Set(HeaderValueInterface::class))
                ->add(new HeaderValue('foo'))
        );
    }

    /**
     * @expectedException Innmind\Http\Exception\AgeMustContainOnlyOneValueException
     */
    public function testThrowIfNoValueGiven()
    {
        new Age(new Set(HeaderValueInterface::class));
    }

    /**
     * @expectedException Innmind\Http\Exception\AgeMustContainOnlyOneValueException
     */
    public function testThrowIfTooManyValuesGiven()
    {
        new Age(
            (new Set(HeaderValueInterface::class))
                ->add(new AgeValue(42))
                ->add(new AgeValue(24))
        );
    }
}
