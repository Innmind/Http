<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\{
    Allow,
    HeaderInterface,
    HeaderValueInterface,
    HeaderValue,
    AllowValue
};
use Innmind\Immutable\Set;

class AllowTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $h = new Allow(
            $v = (new Set(HeaderValueInterface::class))
                ->add(new AllowValue('GET'))
        );

        $this->assertInstanceOf(HeaderInterface::class, $h);
        $this->assertSame('Allow', $h->name());
        $this->assertSame($v, $h->values());
        $this->assertSame('Allow : GET', (string) $h);
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testRangeThrowWhenBuildingWithoutAllowValue()
    {
        new Allow(
            (new Set(HeaderValueInterface::class))
                ->add(new HeaderValue('foo'))
        );
    }
}
