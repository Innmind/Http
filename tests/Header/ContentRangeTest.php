<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\ContentRange,
    Header,
    Header\ContentRangeValue
};
use Innmind\Immutable\Sequence;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class ContentRangeTest extends TestCase
{
    public function testInterface()
    {
        $h = new ContentRange(
            $cr = new ContentRangeValue('bytes', 0, 42),
        );

        $this->assertInstanceOf(Header::class, $h);
        $this->assertSame('Content-Range', $h->name());
        $v = $h->values();
        $this->assertInstanceOf(Sequence::class, $v);
        $this->assertSame($cr, $v->find(static fn() => true)->match(
            static fn($first) => $first,
            static fn() => null,
        ));
        $this->assertSame('Content-Range: bytes 0-42/*', $h->toString());
        $this->assertSame('bytes 0-42/*', $h->range()->toString());
    }

    public function testOf()
    {
        $header = ContentRange::of('bytes', 0, 42);

        $this->assertInstanceOf(ContentRange::class, $header);
        $this->assertSame('Content-Range: bytes 0-42/*', $header->toString());
    }
}
