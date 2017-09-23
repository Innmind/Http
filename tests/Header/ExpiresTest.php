<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\Expires,
    Header,
    Header\Value,
    Header\DateValue
};
use Innmind\Immutable\SetInterface;
use PHPUnit\Framework\TestCase;

class ExpiresTest extends TestCase
{
    public function testInterface()
    {
        $h = new Expires(
            $d = new DateValue(new \DateTime('2016-01-01 12:12:12+0200'))
        );

        $this->assertInstanceOf(Header::class, $h);
        $this->assertSame('Expires', $h->name());
        $v = $h->values();
        $this->assertInstanceOf(SetInterface::class, $v);
        $this->assertSame(Value::class, (string) $v->type());
        $this->assertSame($d, $v->current());
        $this->assertSame('Expires : Fri, 01 Jan 2016 12:12:12 +0200', (string) $h);
    }
}
