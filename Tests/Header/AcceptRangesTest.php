<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Header;

use Innmind\Http\Header\{
    AcceptRanges,
    HeaderInterface,
    HeaderValueInterface,
    HeaderValue,
    AcceptRangesValue
};
use Innmind\Immutable\Set;

class AcceptRangesTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $h = new AcceptRanges(
            $v = (new Set(HeaderValueInterface::class))
                ->add(new AcceptRangesValue('bytes'))
        );

        $this->assertInstanceOf(HeaderInterface::class, $h);
        $this->assertSame('Accept-Ranges', $h->name());
        $this->assertSame($v, $h->values());
        $this->assertSame('Accept-Ranges : bytes', (string) $h);
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testRangeThrowWhenBuildingWithoutAcceptValues()
    {
        new AcceptRanges(
            (new Set(HeaderValueInterface::class))
                ->add(new HeaderValue('foo'))
        );
    }

    /**
     * @expectedException Innmind\Http\Exception\AcceptRangesMustContainOnlyOneValueException
     */
    public function testThrowIfNoValueGiven()
    {
        new AcceptRanges(new Set(HeaderValueInterface::class));
    }

    /**
     * @expectedException Innmind\Http\Exception\AcceptRangesMustContainOnlyOneValueException
     */
    public function testThrowIfTooManyValuesGiven()
    {
        new AcceptRanges(
            (new Set(HeaderValueInterface::class))
                ->add(new AcceptRangesValue('bytes'))
                ->add(new AcceptRangesValue('none'))
        );
    }
}
