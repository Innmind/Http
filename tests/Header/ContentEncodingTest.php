<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\{
    ContentEncoding,
    HeaderInterface,
    HeaderValueInterface,
    ContentEncodingValue
};
use Innmind\Immutable\SetInterface;

class ContentEncodingTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $h = new ContentEncoding(
            $ce = new ContentEncodingValue('compress')
        );

        $this->assertInstanceOf(HeaderInterface::class, $h);
        $this->assertSame('Content-Encoding', $h->name());
        $v = $h->values();
        $this->assertInstanceOf(SetInterface::class, $v);
        $this->assertSame(HeaderValueInterface::class, (string) $v->type());
        $this->assertSame($ce, $v->current());
        $this->assertSame('Content-Encoding : compress', (string) $h);
    }
}
