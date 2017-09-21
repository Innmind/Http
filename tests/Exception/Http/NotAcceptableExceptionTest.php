<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    NotAcceptableException,
    Exception
};
use PHPUnit\Framework\TestCase;

class NotAcceptableExceptionTest extends TestCase
{
    public function testInterface()
    {
        $e = new NotAcceptableException;

        $this->assertInstanceOf(Exception::class, $e);
        $this->assertSame(406, $e->httpCode());
    }
}
