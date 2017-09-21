<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    Locked,
    Exception
};
use PHPUnit\Framework\TestCase;

class LockedTest extends TestCase
{
    public function testInterface()
    {
        $e = new Locked;

        $this->assertInstanceOf(Exception::class, $e);
        $this->assertSame(423, $e->httpCode());
    }
}
