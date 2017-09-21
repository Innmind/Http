<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    LengthRequired,
    Exception
};
use PHPUnit\Framework\TestCase;

class LengthRequiredTest extends TestCase
{
    public function testInterface()
    {
        $e = new LengthRequired;

        $this->assertInstanceOf(Exception::class, $e);
        $this->assertSame(411, $e->httpCode());
    }
}
