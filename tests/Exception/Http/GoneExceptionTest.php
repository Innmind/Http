<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    GoneException,
    ExceptionInterface
};
use PHPUnit\Framework\TestCase;

class GoneExceptionTest extends TestCase
{
    public function testInterface()
    {
        $e = new GoneException;

        $this->assertInstanceOf(ExceptionInterface::class, $e);
        $this->assertSame(410, $e->httpCode());
    }
}
