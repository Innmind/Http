<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\ContentLocation,
    Header,
    Header\Value,
    Header\LocationValue
};
use Innmind\Immutable\Set;
use Innmind\Url\Url;
use PHPUnit\Framework\TestCase;

class ContentLocationTest extends TestCase
{
    public function testInterface()
    {
        $h = new ContentLocation(
            $av = new LocationValue(Url::of('/foo/bar'))
        );

        $this->assertInstanceOf(Header::class, $h);
        $this->assertSame('Content-Location', $h->name());
        $v = $h->values();
        $this->assertInstanceOf(Set::class, $v);
        $this->assertSame($av, $v->find(static fn() => true)->match(
            static fn($first) => $first,
            static fn() => null,
        ));
        $this->assertSame('Content-Location: /foo/bar', $h->toString());
    }

    public function testOf()
    {
        $header = ContentLocation::of(Url::of('/foo/bar'));

        $this->assertInstanceOf(ContentLocation::class, $header);
        $this->assertSame('Content-Location: /foo/bar', $header->toString());
    }
}
