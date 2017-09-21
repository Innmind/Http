<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\AcceptRanges,
    Header,
    Header\HeaderValue,
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
        $this->assertSame(HeaderValue::class, (string) $v->type());
        $this->assertSame($ar, $v->current());
        $this->assertSame('Accept-Ranges : bytes', (string) $h);
    }
}
