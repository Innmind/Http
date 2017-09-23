<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    MethodNotAllowed,
    Exception
};
use PHPUnit\Framework\TestCase;

class MethodNotAllowedTest extends TestCase
{
    public function testInterface()
    {
        $e = new MethodNotAllowed;

        $this->assertInstanceOf(Exception::class, $e);
        $this->assertSame(405, $e->httpCode());
    }
}
