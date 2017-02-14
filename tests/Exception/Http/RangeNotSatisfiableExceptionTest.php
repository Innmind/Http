<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    RangeNotSatisfiableException,
    ExceptionInterface
};
use PHPUnit\Framework\TestCase;

class RangeNotSatisfiableExceptionTest extends TestCase
{
    public function testInterface()
    {
        $e = new RangeNotSatisfiableException;

        $this->assertInstanceOf(ExceptionInterface::class, $e);
        $this->assertSame(416, $e->httpCode());
    }
}
