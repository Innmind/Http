<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    PaymentRequired,
    Exception
};
use PHPUnit\Framework\TestCase;

class PaymentRequiredTest extends TestCase
{
    public function testInterface()
    {
        $e = new PaymentRequired;

        $this->assertInstanceOf(Exception::class, $e);
        $this->assertSame(402, $e->httpCode());
    }
}
