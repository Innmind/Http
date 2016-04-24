<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Header;

use Innmind\Http\Header\{
    Host,
    HeaderInterface,
    HeaderValueInterface,
    HostValue
};
use Innmind\Immutable\SetInterface;
use Innmind\Url\Authority\{
    Host as UrlHost,
    NullPort
};

class HostTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $h = new Host(
            $av = new HostValue(new UrlHost('example.com'), new NullPort)
        );

        $this->assertInstanceOf(HeaderInterface::class, $h);
        $this->assertSame('Host', $h->name());
        $v = $h->values();
        $this->assertInstanceOf(SetInterface::class, $v);
        $this->assertSame(HeaderValueInterface::class, (string) $v->type());
        $this->assertSame($av, $v->current());
        $this->assertSame('Host : example.com', (string) $h);
    }
}
