<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\Location,
    Header,
};
use Innmind\Url\Url;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class LocationTest extends TestCase
{
    public function testInterface()
    {
        $h = Location::of(
            Url::of('/foo/bar'),
        );

        $this->assertInstanceOf(Header\Custom::class, $h);
        $this->assertSame('Location: /foo/bar', $h->normalize()->toString());
    }

    public function testOf()
    {
        $header = Location::of(Url::of('/foo/bar'));

        $this->assertInstanceOf(Location::class, $header);
        $this->assertSame('Location: /foo/bar', $header->normalize()->toString());
    }
}
