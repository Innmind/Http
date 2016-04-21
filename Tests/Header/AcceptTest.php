<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Header;

use Innmind\Http\Header\{
    Accept,
    HeaderInterface,
    HeaderValueInterface,
    HeaderValue,
    AcceptValue
};
use Innmind\Immutable\Set;

class AcceptTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $h = new Accept(
            $v = (new Set(HeaderValueInterface::class))
                ->add(new AcceptValue('text/html;q=0.8'))
        );

        $this->assertInstanceOf(HeaderInterface::class, $h);
        $this->assertSame('Accept', $h->name());
        $this->assertSame($v, $h->values());
        $this->assertSame('Accept : text/html;q=0.8', (string) $h);
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenBuildingWithoutAcceptValues()
    {
        new Accept(
            (new Set(HeaderValueInterface::class))
                ->add(new HeaderValue('foo'))
        );
    }

    /**
     * @expectedException Innmind\Http\Exception\AceptHeaderMustContainAtLeastOneValueException
     */
    public function testThrowIfNoValueGiven()
    {
        new Accept(new Set(HeaderValueInterface::class));
    }
}
