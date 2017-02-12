<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    UnprocessableEntityException,
    ExceptionInterface
};
use PHPUnit\Framework\TestCase;

class UnprocessableEntityExceptionTest extends TestCase
{
    public function testInterface()
    {
        $e = new UnprocessableEntityException;

        $this->assertInstanceOf(ExceptionInterface::class, $e);
        $this->assertSame(422, $e->httpCode());
    }
}
