<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    ExpectationFailedException,
    Exception
};
use PHPUnit\Framework\TestCase;

class ExpectationFailedExceptionTest extends TestCase
{
    public function testInterface()
    {
        $e = new ExpectationFailedException;

        $this->assertInstanceOf(Exception::class, $e);
        $this->assertSame(417, $e->httpCode());
    }
}
