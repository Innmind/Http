<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    PreconditionFailedException,
    Exception
};
use PHPUnit\Framework\TestCase;

class PreconditionFailedExceptionTest extends TestCase
{
    public function testInterface()
    {
        $e = new PreconditionFailedException;

        $this->assertInstanceOf(Exception::class, $e);
        $this->assertSame(412, $e->httpCode());
    }
}
