<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    RequestTimeout,
    Exception
};
use PHPUnit\Framework\TestCase;

class RequestTimeoutExceptionTest extends TestCase
{
    public function testInterface()
    {
        $e = new RequestTimeout;

        $this->assertInstanceOf(Exception::class, $e);
        $this->assertSame(408, $e->httpCode());
    }
}
