<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\Link,
    Header,
    Header\Value,
    Header\LinkValue,
    Header\Parameter
};
use Innmind\Url\Url;
use Innmind\Immutable\{
    Set,
    Map
};
use PHPUnit\Framework\TestCase;

class LinkTest extends TestCase
{
    public function testInterface()
    {
        $h = new Link(
            $v = (new Set(Value::class))
                ->add(new LinkValue(
                    Url::fromString('/some/resource'),
                    'some relation',
                    (new Map('string', Parameter::class))
                        ->put('title', new Parameter\Parameter('title', 'Foo'))
                ))
        );

        $this->assertInstanceOf(Header::class, $h);
        $this->assertSame('Link', $h->name());
        $this->assertSame($v, $h->values());
        $this->assertSame(
            'Link : </some/resource>; rel="some relation";title=Foo',
            (string) $h
        );
    }

    public function testWithoutValues()
    {
        $this->assertSame('Link : ', (string) new Link);
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenBuildingWithoutLinkValues()
    {
        new Link(
            (new Set(Value::class))
                ->add(new Value\Value('foo'))
        );
    }
}
