<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Header;

use Innmind\Http\Header\{
    AcceptRanges,
    HeaderInterface,
    HeaderValueInterface,
    AcceptRangesValue
};
use Innmind\Immutable\SetInterface;

class AcceptRangesTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $h = new AcceptRanges(
            $ar = new AcceptRangesValue('bytes')
        );

        $this->assertInstanceOf(HeaderInterface::class, $h);
        $this->assertSame('Accept-Ranges', $h->name());
        $v = $h->values();
        $this->assertInstanceOf(SetInterface::class, $v);
        $this->assertSame(HeaderValueInterface::class, (string) $v->type());
        $this->assertSame($ar, $v->current());
        $this->assertSame('Accept-Ranges : bytes', (string) $h);
    }
}
