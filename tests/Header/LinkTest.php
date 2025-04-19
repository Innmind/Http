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
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class LinkTest extends TestCase
{
    public function testInterface()
    {
        $h = new Link(
            $v = new LinkValue(
                Url::of('/some/resource'),
                'some relation',
                new Parameter\Parameter('title', 'Foo'),
            ),
        );

        $this->assertInstanceOf(Header\Provider::class, $h);
        $this->assertSame(
            'Link: </some/resource>; rel="some relation";title=Foo',
            $h->toHeader()->toString(),
        );
    }

    public function testWithoutValues()
    {
        $this->assertSame('Link: ', (new Link)->toHeader()->toString());
    }
}
