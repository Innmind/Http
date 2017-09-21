<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    PreconditionRequired,
    Exception
};
use PHPUnit\Framework\TestCase;

class PreconditionRequiredTest extends TestCase
{
    public function testInterface()
    {
        $e = new PreconditionRequired;

        $this->assertInstanceOf(Exception::class, $e);
        $this->assertSame(428, $e->httpCode());
    }
}
