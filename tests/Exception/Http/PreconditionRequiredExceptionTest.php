<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    PreconditionRequiredException,
    Exception
};
use PHPUnit\Framework\TestCase;

class PreconditionRequiredExceptionTest extends TestCase
{
    public function testInterface()
    {
        $e = new PreconditionRequiredException;

        $this->assertInstanceOf(Exception::class, $e);
        $this->assertSame(428, $e->httpCode());
    }
}
