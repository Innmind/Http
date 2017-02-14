<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    RequestTimeoutException,
    ExceptionInterface
};
use PHPUnit\Framework\TestCase;

class RequestTimeoutExceptionTest extends TestCase
{
    public function testInterface()
    {
        $e = new RequestTimeoutException;

        $this->assertInstanceOf(ExceptionInterface::class, $e);
        $this->assertSame(408, $e->httpCode());
    }
}
