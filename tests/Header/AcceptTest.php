<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\Accept,
    Header,
    Header\Value,
    Header\AcceptValue,
    Header\Parameter\Quality,
    Header\Parameter
};
use Innmind\Immutable\{
    Set,
    Map
};
use PHPUnit\Framework\TestCase;

class AcceptTest extends TestCase
{
    public function testInterface()
    {
        $h = new Accept(
            $v = (new Set(Value::class))
                ->add(new AcceptValue(
                    'text',
                    'html',
                    (new Map('string', Parameter::class))
                        ->put('q', new Quality(0.8))
                ))
        );

        $this->assertInstanceOf(Header::class, $h);
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
            (new Set(Value::class))
                ->add(new Value\Value('foo'))
        );
    }

    /**
     * @expectedException Innmind\Http\Exception\AcceptHeaderMustContainAtLeastOneValue
     */
    public function testThrowIfNoValueGiven()
    {
        new Accept(new Set(Value::class));
    }
}
