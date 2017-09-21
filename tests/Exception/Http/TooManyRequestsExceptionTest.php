<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    TooManyRequestsException,
    Exception
};
use PHPUnit\Framework\TestCase;

class TooManyRequestsExceptionTest extends TestCase
{
    public function testInterface()
    {
        $e = new TooManyRequestsException;

        $this->assertInstanceOf(Exception::class, $e);
        $this->assertSame(429, $e->httpCode());
    }
}
