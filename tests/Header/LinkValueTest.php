<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\LinkValue,
    Header\Value,
    Header\Parameter,
    Exception\DomainException,
};
use Innmind\Url\Url;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class LinkValueTest extends TestCase
{
    public function testInterface()
    {
        $l = new LinkValue(
            $url = Url::of('/some/resource'),
            'relationship',
            $p = new Parameter\Parameter('title', 'Foo'),
        );

        $this->assertInstanceOf(Value::class, $l);
        $this->assertSame($url, $l->url());
        $this->assertSame('relationship', $l->relationship());
        $this->assertSame($p, $l->parameters()->get('title')->match(
            static fn($title) => $title,
            static fn() => null,
        ));
        $this->assertSame(
            '</some/resource>; rel="relationship";title=Foo',
            $l->toString(),
        );
    }

    public function testDefaultRelationship()
    {
        $this->assertSame(
            'related',
            (new LinkValue(Url::of('/')))->relationship(),
        );
    }

    public function testThrowWhenInvalidLinkValue()
    {
        $this->expectException(DomainException::class);

        new LinkValue(
            Url::of('/foo'),
            '',
        );
    }
}
