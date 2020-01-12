<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\ContentRange,
    Header,
    Header\Value,
    Header\ContentRangeValue
};
use Innmind\Immutable\Set;
use function Innmind\Immutable\first;
use PHPUnit\Framework\TestCase;

class ContentRangeTest extends TestCase
{
    public function testInterface()
    {
        $h = new ContentRange(
            $cr = new ContentRangeValue('bytes', 0, 42)
        );

        $this->assertInstanceOf(Header::class, $h);
        $this->assertSame('Content-Range', $h->name());
        $v = $h->values();
        $this->assertInstanceOf(Set::class, $v);
        $this->assertSame(Value::class, (string) $v->type());
        $this->assertSame($cr, first($v));
        $this->assertSame('Content-Range: bytes 0-42/*', $h->toString());
    }

    public function testOf()
    {
        $header = ContentRange::of('bytes', 0, 42);

        $this->assertInstanceOf(ContentRange::class, $header);
        $this->assertSame('Content-Range: bytes 0-42/*', $header->toString());
    }
}
