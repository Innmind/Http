<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    GoneException,
    Exception
};
use PHPUnit\Framework\TestCase;

class GoneExceptionTest extends TestCase
{
    public function testInterface()
    {
        $e = new GoneException;

        $this->assertInstanceOf(Exception::class, $e);
        $this->assertSame(410, $e->httpCode());
    }
}
