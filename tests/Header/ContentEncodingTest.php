<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\ContentEncoding,
    Header,
    Header\Value,
    Header\ContentEncodingValue
};
use Innmind\Immutable\SetInterface;
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
        $this->assertInstanceOf(SetInterface::class, $v);
        $this->assertSame(Value::class, (string) $v->type());
        $this->assertSame($ce, $v->current());
        $this->assertSame('Content-Encoding: compress', (string) $h);
    }
}
