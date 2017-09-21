<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    MisdirectedRequestException,
    Exception
};
use PHPUnit\Framework\TestCase;

class MisdirectedRequestExceptionTest extends TestCase
{
    public function testInterface()
    {
        $e = new MisdirectedRequestException;

        $this->assertInstanceOf(Exception::class, $e);
        $this->assertSame(421, $e->httpCode());
    }
}
