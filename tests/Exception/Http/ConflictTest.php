<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    Conflict,
    Exception
};
use PHPUnit\Framework\TestCase;

class ConflictTest extends TestCase
{
    public function testInterface()
    {
        $e = new Conflict;

        $this->assertInstanceOf(Exception::class, $e);
        $this->assertSame(409, $e->httpCode());
    }
}
