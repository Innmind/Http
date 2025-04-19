<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\Host,
    Header,
    Header\HostValue
};
use Innmind\Immutable\Sequence;
use Innmind\Url\Authority\{
    Host as UrlHost,
    Port,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class HostTest extends TestCase
{
    public function testInterface()
    {
        $h = new Host(
            $av = new HostValue(UrlHost::of('example.com'), Port::none()),
        );

        $this->assertInstanceOf(Header::class, $h);
        $this->assertSame('Host', $h->name());
        $v = $h->values();
        $this->assertInstanceOf(Sequence::class, $v);
        $this->assertSame($av, $v->find(static fn() => true)->match(
            static fn($first) => $first,
            static fn() => null,
        ));
        $this->assertSame('Host: example.com', $h->toString());
        $this->assertSame($av->host(), $h->host());
        $this->assertSame($av->port(), $h->port());
    }

    public function testOf()
    {
        $header = Host::of(UrlHost::of('example.com'), Port::none());

        $this->assertInstanceOf(Host::class, $header);
        $this->assertSame('Host: example.com', $header->toString());
    }
}
