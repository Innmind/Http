<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\Link,
    Header,
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
            $v = new LinkValue(
                Url::fromString('/some/resource'),
                'some relation',
                new Parameter\Parameter('title', 'Foo'),
            )
        );

        $this->assertInstanceOf(Header::class, $h);
        $this->assertSame('Link', $h->name());
        $this->assertTrue($h->values()->contains($v));
        $this->assertSame(
            'Link: </some/resource>; rel="some relation";title=Foo',
            (string) $h
        );
    }

    public function testWithoutValues()
    {
        $this->assertSame('Link: ', (string) new Link);
    }
}
