<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\{
    Link,
    HeaderInterface,
    HeaderValueInterface,
    HeaderValue,
    LinkValue,
    ParameterInterface,
    Parameter
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
            $v = (new Set(HeaderValueInterface::class))
                ->add(new LinkValue(
                    Url::fromString('/some/resource'),
                    'some relation',
                    (new Map('string', ParameterInterface::class))
                        ->put('title', new Parameter('title', 'Foo'))
                ))
        );

        $this->assertInstanceOf(HeaderInterface::class, $h);
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
            (new Set(HeaderValueInterface::class))
                ->add(new HeaderValue('foo'))
        );
    }
}
