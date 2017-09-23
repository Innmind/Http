<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\{
    LinkValue,
    HeaderValue,
    Parameter
};
use Innmind\Url\Url;
use Innmind\Immutable\Map;
use PHPUnit\Framework\TestCase;

class LinkValueTest extends TestCase
{
    public function testInterface()
    {
        $l = new LinkValue(
            $url = Url::fromString('/some/resource'),
            'relationship',
            $ps = (new Map('string', Parameter::class))
                ->put('title', new Parameter\Parameter('title', 'Foo'))
        );

        $this->assertInstanceOf(HeaderValue::class, $l);
        $this->assertSame($url, $l->url());
        $this->assertSame('relationship', $l->relationship());
        $this->assertSame($ps, $l->parameters());
        $this->assertSame(
            '</some/resource>; rel="relationship";title=Foo',
            (string) $l
        );
    }

    public function testDefaultRelationship()
    {
        $this->assertSame(
            'related',
            (new LinkValue(Url::fromString('/')))->relationship()
        );
    }

    /**
     * @expectedException TypeError
     * @expectedExceptionMessage Argument 3 must be of type MapInterface<string, Innmind\Http\Header\Parameter>
     */
    public function testThrowWhenInvalidParameters()
    {
        new LinkValue(Url::fromString('/foo'), 'rel', new Map('string', 'string'));
    }

    /**
     * @expectedException Innmind\Http\Exception\DomainException
     */
    public function testThrowWhenInvalidLinkValue()
    {
        new LinkValue(
            Url::fromString('/foo'),
            ''
        );
    }
}
