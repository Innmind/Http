<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    NotFound,
    Exception
};
use PHPUnit\Framework\TestCase;

class NotFoundTest extends TestCase
{
    public function testInterface()
    {
        $e = new NotFound;

        $this->assertInstanceOf(Exception::class, $e);
        $this->assertSame(404, $e->httpCode());
    }
}
