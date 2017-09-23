<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    TooManyRequests,
    Exception
};
use PHPUnit\Framework\TestCase;

class TooManyRequestsTest extends TestCase
{
    public function testInterface()
    {
        $e = new TooManyRequests;

        $this->assertInstanceOf(Exception::class, $e);
        $this->assertSame(429, $e->httpCode());
    }
}
