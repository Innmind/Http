<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\{
    Referrer,
    HeaderInterface,
    HeaderValueInterface,
    ReferrerValue
};
use Innmind\Immutable\SetInterface;
use Innmind\Url\Url;

class ReferrerTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $h = new Referrer(
            $av = new ReferrerValue(Url::fromString('/foo/bar'))
        );

        $this->assertInstanceOf(HeaderInterface::class, $h);
        $this->assertSame('Referer', $h->name());
        $v = $h->values();
        $this->assertInstanceOf(SetInterface::class, $v);
        $this->assertSame(HeaderValueInterface::class, (string) $v->type());
        $this->assertSame($av, $v->current());
        $this->assertSame('Referer : /foo/bar', (string) $h);
    }
}
