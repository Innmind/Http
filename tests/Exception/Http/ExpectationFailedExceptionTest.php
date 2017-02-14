<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    ExpectationFailedException,
    ExceptionInterface
};
use PHPUnit\Framework\TestCase;

class ExpectationFailedExceptionTest extends TestCase
{
    public function testInterface()
    {
        $e = new ExpectationFailedException;

        $this->assertInstanceOf(ExceptionInterface::class, $e);
        $this->assertSame(417, $e->httpCode());
    }
}
