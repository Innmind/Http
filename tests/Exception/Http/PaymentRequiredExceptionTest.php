<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    PaymentRequiredException,
    ExceptionInterface
};

class PaymentRequiredExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $e = new PaymentRequiredException;

        $this->assertInstanceOf(ExceptionInterface::class, $e);
        $this->assertSame(402, $e->httpCode());
    }
}
