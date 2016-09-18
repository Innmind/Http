<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\{
    HostValue,
    HeaderValueInterface
};
use Innmind\Url\Authority\{
    Host,
    NullPort,
    Port
};

class HostValueTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $h = new HostValue($host = new Host('example.com'), $p = new NullPort);

        $this->assertInstanceOf(HeaderValueInterface::class, $h);
        $this->assertSame($host, $h->host());
        $this->assertSame($p, $h->port());
        $this->assertSame('example.com', (string) $h);
        $this->assertSame(
            'example.com:8080',
            (string) new HostValue(new Host('example.com'), new Port(8080))
        );
    }
}