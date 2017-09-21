<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    NotImplementedException,
    Exception
};
use PHPUnit\Framework\TestCase;

class NotImplementedExceptionTest extends TestCase
{
    public function testInterface()
    {
        $e = new NotImplementedException;

        $this->assertInstanceOf(Exception::class, $e);
        $this->assertSame(501, $e->httpCode());
    }
}
