<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\{
    HostValue,
    Value
};
use Innmind\Url\Authority\{
    Host,
    Port,
};
use PHPUnit\Framework\TestCase;

class HostValueTest extends TestCase
{
    public function testInterface()
    {
        $h = new HostValue($host = Host::of('example.com'), $p = Port::none());

        $this->assertInstanceOf(Value::class, $h);
        $this->assertSame($host, $h->host());
        $this->assertSame($p, $h->port());
        $this->assertSame('example.com', $h->toString());
        $this->assertSame(
            'example.com:8080',
            (new HostValue(Host::of('example.com'), Port::of(8080)))->toString(),
        );
    }
}
