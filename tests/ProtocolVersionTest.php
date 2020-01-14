<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http;

use Innmind\Http\ProtocolVersion;
use PHPUnit\Framework\TestCase;

class ProtocolVersionTest extends TestCase
{
    public function testInterface()
    {
        $p = new ProtocolVersion(2, 0);

        $this->assertSame(2, $p->major());
        $this->assertSame(0, $p->minor());
        $this->assertSame('2.0', $p->toString());
    }
}
