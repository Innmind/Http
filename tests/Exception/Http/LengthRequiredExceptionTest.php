<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    LengthRequiredException,
    ExceptionInterface
};
use PHPUnit\Framework\TestCase;

class LengthRequiredExceptionTest extends TestCase
{
    public function testInterface()
    {
        $e = new LengthRequiredException;

        $this->assertInstanceOf(ExceptionInterface::class, $e);
        $this->assertSame(411, $e->httpCode());
    }
}
