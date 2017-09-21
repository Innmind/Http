<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    ForbiddenException,
    Exception
};
use PHPUnit\Framework\TestCase;

class ForbiddenExceptionTest extends TestCase
{
    public function testInterface()
    {
        $e = new ForbiddenException;

        $this->assertInstanceOf(Exception::class, $e);
        $this->assertSame(403, $e->httpCode());
    }
}
