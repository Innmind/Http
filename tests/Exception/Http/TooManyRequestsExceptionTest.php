<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    TooManyRequestsException,
    ExceptionInterface
};

class TooManyRequestsExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $e = new TooManyRequestsException;

        $this->assertInstanceOf(ExceptionInterface::class, $e);
        $this->assertSame(429, $e->httpCode());
    }
}
