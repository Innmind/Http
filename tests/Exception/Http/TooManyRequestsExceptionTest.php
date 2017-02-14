<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    TooManyRequestsException,
    ExceptionInterface
};
use PHPUnit\Framework\TestCase;

class TooManyRequestsExceptionTest extends TestCase
{
    public function testInterface()
    {
        $e = new TooManyRequestsException;

        $this->assertInstanceOf(ExceptionInterface::class, $e);
        $this->assertSame(429, $e->httpCode());
    }
}
