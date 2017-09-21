<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    PaymentRequiredException,
    Exception
};
use PHPUnit\Framework\TestCase;

class PaymentRequiredExceptionTest extends TestCase
{
    public function testInterface()
    {
        $e = new PaymentRequiredException;

        $this->assertInstanceOf(Exception::class, $e);
        $this->assertSame(402, $e->httpCode());
    }
}
