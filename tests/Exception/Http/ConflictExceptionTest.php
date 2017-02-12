<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    ConflictException,
    ExceptionInterface
};
use PHPUnit\Framework\TestCase;

class ConflictExceptionTest extends TestCase
{
    public function testInterface()
    {
        $e = new ConflictException;

        $this->assertInstanceOf(ExceptionInterface::class, $e);
        $this->assertSame(409, $e->httpCode());
    }
}
