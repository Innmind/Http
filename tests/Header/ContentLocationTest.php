<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\ContentLocation,
    Header,
};
use Innmind\Immutable\Sequence;
use Innmind\Url\Url;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class ContentLocationTest extends TestCase
{
    public function testInterface()
    {
        $h = ContentLocation::of(Url::of('/foo/bar'));

        $this->assertInstanceOf(Header::class, $h);
        $this->assertSame('Content-Location', $h->name());
        $v = $h->values();
        $this->assertInstanceOf(Sequence::class, $v);
        $this->assertSame('Content-Location: /foo/bar', $h->toString());
        $this->assertSame('/foo/bar', $h->url()->toString());
    }

    public function testOf()
    {
        $header = ContentLocation::of(Url::of('/foo/bar'));

        $this->assertInstanceOf(ContentLocation::class, $header);
        $this->assertSame('Content-Location: /foo/bar', $header->toString());
    }
}
