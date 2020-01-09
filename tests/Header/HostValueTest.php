<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\{
    HostValue,
    Value
};
use Innmind\Url\Authority\{
    Host,
    NullPort,
    Port
};
use PHPUnit\Framework\TestCase;

class HostValueTest extends TestCase
{
    public function testInterface()
    {
        $h = new HostValue($host = new Host('example.com'), $p = new NullPort);

        $this->assertInstanceOf(Value::class, $h);
        $this->assertSame($host, $h->host());
        $this->assertSame($p, $h->port());
        $this->assertSame('example.com', $h->toString());
        $this->assertSame(
            'example.com:8080',
            (new HostValue(new Host('example.com'), new Port(8080)))->toString(),
        );
    }
}
