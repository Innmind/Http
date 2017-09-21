<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    Unauthorized,
    Exception
};
use PHPUnit\Framework\TestCase;

class UnauthorizedTest extends TestCase
{
    public function testInterface()
    {
        $e = new Unauthorized;

        $this->assertInstanceOf(Exception::class, $e);
        $this->assertSame(401, $e->httpCode());
    }
}
