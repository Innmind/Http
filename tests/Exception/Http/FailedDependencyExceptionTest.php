<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    FailedDependencyException,
    Exception
};
use PHPUnit\Framework\TestCase;

class FailedDependencyExceptionTest extends TestCase
{
    public function testInterface()
    {
        $e = new FailedDependencyException;

        $this->assertInstanceOf(Exception::class, $e);
        $this->assertSame(424, $e->httpCode());
    }
}
