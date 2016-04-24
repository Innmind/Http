<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Header;

use Innmind\Http\Header\{
    LastModified,
    HeaderInterface,
    HeaderValueInterface,
    DateValue
};
use Innmind\Immutable\SetInterface;

class LastModifiedTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $h = new LastModified(
            $d = new DateValue(new \DateTime('2016-01-01 12:12:12+0200'))
        );

        $this->assertInstanceOf(HeaderInterface::class, $h);
        $this->assertSame('Last-Modified', $h->name());
        $v = $h->values();
        $this->assertInstanceOf(SetInterface::class, $v);
        $this->assertSame(HeaderValueInterface::class, (string) $v->type());
        $this->assertSame($d, $v->current());
        $this->assertSame('Last-Modified : Fri, 01 Jan 2016 12:12:12 +0200', (string) $h);
    }
}
