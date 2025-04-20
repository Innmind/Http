<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\{
    Link\Relationship,
    Parameter,
};
use Innmind\Url\Url;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class LinkValueTest extends TestCase
{
    public function testInterface()
    {
        $l = Relationship::of(
            $url = Url::of('/some/resource'),
            'relationship',
            $p = Parameter::of('title', 'Foo'),
        );

        $this->assertInstanceOf(Relationship::class, $l);
        $this->assertSame($url, $l->url());
        $this->assertSame('relationship', $l->kind());
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
            Relationship::of(Url::of('/'))->kind(),
        );
    }
}
