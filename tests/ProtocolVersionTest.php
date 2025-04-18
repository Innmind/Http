<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http;

use Innmind\Http\ProtocolVersion;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class ProtocolVersionTest extends TestCase
{
    public function testInterface()
    {
        $this->assertSame('1.0', ProtocolVersion::v10->toString());
        $this->assertSame('1.1', ProtocolVersion::v11->toString());
        $this->assertSame('2.0', ProtocolVersion::v20->toString());
    }
}
