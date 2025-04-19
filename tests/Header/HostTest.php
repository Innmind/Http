<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\Host,
    Header,
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
        $h = Host::of(
            UrlHost::of('example.com'),
            Port::of(8080),
        );

        $this->assertInstanceOf(Header::class, $h);
        $this->assertSame('Host', $h->name());
        $v = $h->values();
        $this->assertInstanceOf(Sequence::class, $v);
        $this->assertSame('Host: example.com:8080', $h->toString());
    }

    public function testOf()
    {
        $header = Host::of(UrlHost::of('example.com'), Port::none());

        $this->assertInstanceOf(Host::class, $header);
        $this->assertSame('Host: example.com', $header->toString());
    }
}
