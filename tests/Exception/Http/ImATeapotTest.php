<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    ImATeapot,
    Exception
};
use PHPUnit\Framework\TestCase;

class ImATeapotTest extends TestCase
{
    public function testInterface()
    {
        $e = new ImATeapot;

        $this->assertInstanceOf(Exception::class, $e);
        $this->assertSame(418, $e->httpCode());
    }
}
