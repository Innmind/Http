<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\ContentLocation,
    Header,
};
use Innmind\Url\Url;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class ContentLocationTest extends TestCase
{
    public function testInterface()
    {
        $h = ContentLocation::of(Url::of('/foo/bar'));

        $this->assertInstanceOf(Header\Provider::class, $h);
        $this->assertSame('Content-Location: /foo/bar', $h->toHeader()->toString());
        $this->assertSame('/foo/bar', $h->url()->toString());
    }

    public function testOf()
    {
        $header = ContentLocation::of(Url::of('/foo/bar'));

        $this->assertInstanceOf(ContentLocation::class, $header);
        $this->assertSame('Content-Location: /foo/bar', $header->toHeader()->toString());
    }
}
