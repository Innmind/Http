<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    ImATeapotException,
    ExceptionInterface
};
use PHPUnit\Framework\TestCase;

class ImATeapotExceptionTest extends TestCase
{
    public function testInterface()
    {
        $e = new ImATeapotException;

        $this->assertInstanceOf(ExceptionInterface::class, $e);
        $this->assertSame(418, $e->httpCode());
    }
}
