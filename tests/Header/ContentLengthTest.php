<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\{
    ContentLength,
    HeaderInterface,
    HeaderValueInterface,
    ContentLengthValue
};
use Innmind\Immutable\SetInterface;

class ContentLengthTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $h = new ContentLength(
            $av = new ContentLengthValue(42)
        );

        $this->assertInstanceOf(HeaderInterface::class, $h);
        $this->assertSame('Content-Length', $h->name());
        $v = $h->values();
        $this->assertInstanceOf(SetInterface::class, $v);
        $this->assertSame(HeaderValueInterface::class, (string) $v->type());
        $this->assertSame($av, $v->current());
        $this->assertSame('Content-Length : 42', (string) $h);
    }
}
