<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\AcceptRanges,
    Header,
    Header\Value,
    Header\AcceptRangesValue
};
use Innmind\Immutable\SetInterface;
use PHPUnit\Framework\TestCase;

class AcceptRangesTest extends TestCase
{
    public function testInterface()
    {
        $h = new AcceptRanges(
            $ar = new AcceptRangesValue('bytes')
        );

        $this->assertInstanceOf(Header::class, $h);
        $this->assertSame('Accept-Ranges', $h->name());
        $v = $h->values();
        $this->assertInstanceOf(SetInterface::class, $v);
        $this->assertSame(Value::class, (string) $v->type());
        $this->assertSame($ar, $v->current());
        $this->assertSame('Accept-Ranges: bytes', $h->toString());
    }

    public function testOf()
    {
        $header = AcceptRanges::of('bytes');

        $this->assertInstanceOf(AcceptRanges::class, $header);
        $this->assertSame('Accept-Ranges', $header->name());
        $values = $header->values();
        $this->assertInstanceOf(SetInterface::class, $values);
        $this->assertSame(Value::class, (string) $values->type());
        $this->assertSame('Accept-Ranges: bytes', $header->toString());
    }
}
