<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http;

use Innmind\Http\{
    ProtocolVersion,
    ProtocolVersionInterface
};

class ProtocolVersionTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $p = new ProtocolVersion(2, 0);

        $this->assertInstanceOf(ProtocolVersionInterface::class, $p);
        $this->assertSame(2, $p->major());
        $this->assertSame(0, $p->minor());
        $this->assertSame('2.0', (string) $p);
    }
}
