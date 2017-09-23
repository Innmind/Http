<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    BadRequest,
    Exception
};
use PHPUnit\Framework\TestCase;

class BadRequestTest extends TestCase
{
    public function testInterface()
    {
        $e = new BadRequest;

        $this->assertInstanceOf(Exception::class, $e);
        $this->assertSame(400, $e->httpCode());
    }
}
