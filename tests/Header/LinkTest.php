<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\Link,
    Header,
    Header\Parameter
};
use Innmind\Url\Url;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class LinkTest extends TestCase
{
    public function testInterface()
    {
        $h = Link::of(
            Link\Relationship::of(
                Url::of('/some/resource'),
                'some relation',
                new Parameter('title', 'Foo'),
            ),
        );

        $this->assertInstanceOf(Header\Custom::class, $h);
        $this->assertSame(
            'Link: </some/resource>; rel="some relation";title=Foo',
            $h->normalize()->toString(),
        );
    }

    public function testWithoutValues()
    {
        $this->assertSame('Link: ', Link::of()->normalize()->toString());
    }
}
