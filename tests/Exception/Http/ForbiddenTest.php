<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    Forbidden,
    Exception
};
use PHPUnit\Framework\TestCase;

class ForbiddenTest extends TestCase
{
    public function testInterface()
    {
        $e = new Forbidden;

        $this->assertInstanceOf(Exception::class, $e);
        $this->assertSame(403, $e->httpCode());
    }
}
