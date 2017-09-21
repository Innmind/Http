<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    RangeNotSatisfiable,
    Exception
};
use PHPUnit\Framework\TestCase;

class RangeNotSatisfiableTest extends TestCase
{
    public function testInterface()
    {
        $e = new RangeNotSatisfiable;

        $this->assertInstanceOf(Exception::class, $e);
        $this->assertSame(416, $e->httpCode());
    }
}
