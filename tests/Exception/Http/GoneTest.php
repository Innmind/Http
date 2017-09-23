<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    Gone,
    Exception
};
use PHPUnit\Framework\TestCase;

class GoneTest extends TestCase
{
    public function testInterface()
    {
        $e = new Gone;

        $this->assertInstanceOf(Exception::class, $e);
        $this->assertSame(410, $e->httpCode());
    }
}
