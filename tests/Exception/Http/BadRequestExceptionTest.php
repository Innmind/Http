<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    BadRequestException,
    ExceptionInterface
};
use PHPUnit\Framework\TestCase;

class BadRequestExceptionTest extends TestCase
{
    public function testInterface()
    {
        $e = new BadRequestException;

        $this->assertInstanceOf(ExceptionInterface::class, $e);
        $this->assertSame(400, $e->httpCode());
    }
}
