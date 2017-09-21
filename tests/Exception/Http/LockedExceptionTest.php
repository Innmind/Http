<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    LockedException,
    Exception
};
use PHPUnit\Framework\TestCase;

class LockedExceptionTest extends TestCase
{
    public function testInterface()
    {
        $e = new LockedException;

        $this->assertInstanceOf(Exception::class, $e);
        $this->assertSame(423, $e->httpCode());
    }
}
