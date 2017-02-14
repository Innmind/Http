<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\{
    ContentLocation,
    HeaderInterface,
    HeaderValueInterface,
    LocationValue
};
use Innmind\Immutable\SetInterface;
use Innmind\Url\Url;
use PHPUnit\Framework\TestCase;

class ContentLocationTest extends TestCase
{
    public function testInterface()
    {
        $h = new ContentLocation(
            $av = new LocationValue(Url::fromString('/foo/bar'))
        );

        $this->assertInstanceOf(HeaderInterface::class, $h);
        $this->assertSame('Content-Location', $h->name());
        $v = $h->values();
        $this->assertInstanceOf(SetInterface::class, $v);
        $this->assertSame(HeaderValueInterface::class, (string) $v->type());
        $this->assertSame($av, $v->current());
        $this->assertSame('Content-Location : /foo/bar', (string) $h);
    }
}
