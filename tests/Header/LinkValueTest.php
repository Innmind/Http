<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\{
    LinkValue,
    Value,
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
            $p = new Parameter\Parameter('title', 'Foo'),
        );

        $this->assertInstanceOf(Value::class, $l);
        $this->assertSame($url, $l->url());
        $this->assertSame('relationship', $l->relationship());
        $this->assertSame($p, $l->parameters()->get('title'));
        $this->assertSame(
            '</some/resource>; rel="relationship";title=Foo',
            $l->toString(),
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
