<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    PayloadTooLargeException,
    ExceptionInterface
};

class PayloadTooLargeExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $e = new PayloadTooLargeException;

        $this->assertInstanceOf(ExceptionInterface::class, $e);
        $this->assertSame(413, $e->httpCode());
    }
}
