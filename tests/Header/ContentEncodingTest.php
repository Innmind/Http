<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\ContentEncoding,
    Header,
    Header\Value,
    Header\ContentEncodingValue
};
use Innmind\Immutable\Set;
use function Innmind\Immutable\first;
use PHPUnit\Framework\TestCase;

class ContentEncodingTest extends TestCase
{
    public function testInterface()
    {
        $h = new ContentEncoding(
            $ce = new ContentEncodingValue('compress')
        );

        $this->assertInstanceOf(Header::class, $h);
        $this->assertSame('Content-Encoding', $h->name());
        $v = $h->values();
        $this->assertInstanceOf(Set::class, $v);
        $this->assertSame(Value::class, (string) $v->type());
        $this->assertSame($ce, first($v));
        $this->assertSame('Content-Encoding: compress', $h->toString());
    }

    public function testOf()
    {
        $header = ContentEncoding::of('compress');

        $this->assertInstanceOf(ContentEncoding::class, $header);
        $this->assertSame('Content-Encoding: compress', $header->toString());
    }
}
