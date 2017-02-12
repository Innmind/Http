<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    MisdirectedRequestException,
    ExceptionInterface
};
use PHPUnit\Framework\TestCase;

class MisdirectedRequestExceptionTest extends TestCase
{
    public function testInterface()
    {
        $e = new MisdirectedRequestException;

        $this->assertInstanceOf(ExceptionInterface::class, $e);
        $this->assertSame(421, $e->httpCode());
    }
}
