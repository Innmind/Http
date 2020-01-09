<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\Host,
    Header,
    Header\Value,
    Header\HostValue
};
use Innmind\Immutable\SetInterface;
use Innmind\Url\Authority\{
    Host as UrlHost,
    NullPort
};
use PHPUnit\Framework\TestCase;

class HostTest extends TestCase
{
    public function testInterface()
    {
        $h = new Host(
            $av = new HostValue(new UrlHost('example.com'), new NullPort)
        );

        $this->assertInstanceOf(Header::class, $h);
        $this->assertSame('Host', $h->name());
        $v = $h->values();
        $this->assertInstanceOf(SetInterface::class, $v);
        $this->assertSame(Value::class, (string) $v->type());
        $this->assertSame($av, $v->current());
        $this->assertSame('Host: example.com', (string) $h);
    }

    public function testOf()
    {
        $header = Host::of(new UrlHost('example.com'), new NullPort);

        $this->assertInstanceOf(Host::class, $header);
        $this->assertSame('Host: example.com', (string) $header);
    }
}
