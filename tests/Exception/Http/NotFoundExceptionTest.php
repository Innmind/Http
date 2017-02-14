<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    NotFoundException,
    ExceptionInterface
};
use PHPUnit\Framework\TestCase;

class NotFoundExceptionTest extends TestCase
{
    public function testInterface()
    {
        $e = new NotFoundException;

        $this->assertInstanceOf(ExceptionInterface::class, $e);
        $this->assertSame(404, $e->httpCode());
    }
}
