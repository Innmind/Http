<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\ContentRange,
    Header,
    Header\Value,
    Header\ContentRangeValue
};
use Innmind\Immutable\SetInterface;
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
        $this->assertInstanceOf(SetInterface::class, $v);
        $this->assertSame(Value::class, (string) $v->type());
        $this->assertSame($cr, $v->current());
        $this->assertSame('Content-Range : bytes 0-42/*', (string) $h);
    }
}
