<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Header;

use Innmind\Http\Header\{
    AcceptRange,
    HeaderInterface,
    HeaderValueInterface,
    HeaderValue,
    AcceptRangeValue
};
use Innmind\Immutable\Set;

class AcceptRangeTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $h = new AcceptRange(
            $v = (new Set(HeaderValueInterface::class))
                ->add(new AcceptRangeValue('bytes'))
        );

        $this->assertInstanceOf(HeaderInterface::class, $h);
        $this->assertSame('Accept', $h->name());
        $this->assertSame($v, $h->values());
        $this->assertSame('Accept : bytes', (string) $h);
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testRangeThrowWhenBuildingWithoutAcceptValues()
    {
        new AcceptRange(
            (new Set(HeaderValueInterface::class))
                ->add(new HeaderValue('foo'))
        );
    }

    /**
     * @expectedException Innmind\Http\Exception\AcceptRangeMustContainOnlyOneValueException
     */
    public function testThrowIfNoValueGiven()
    {
        new AcceptRange(new Set(HeaderValueInterface::class));
    }

    /**
     * @expectedException Innmind\Http\Exception\AcceptRangeMustContainOnlyOneValueException
     */
    public function testThrowIfTooManyValuesGiven()
    {
        new AcceptRange(
            (new Set(HeaderValueInterface::class))
                ->add(new AcceptRangeValue('bytes'))
                ->add(new AcceptRangeValue('none'))
        );
    }
}
