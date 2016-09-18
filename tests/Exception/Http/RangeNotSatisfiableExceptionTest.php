<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    RangeNotSatisfiableException,
    ExceptionInterface
};

class RangeNotSatisfiableExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $e = new RangeNotSatisfiableException;

        $this->assertInstanceOf(ExceptionInterface::class, $e);
        $this->assertSame(416, $e->httpCode());
    }
}