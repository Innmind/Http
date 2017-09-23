<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    NotImplemented,
    Exception
};
use PHPUnit\Framework\TestCase;

class NotImplementedTest extends TestCase
{
    public function testInterface()
    {
        $e = new NotImplemented;

        $this->assertInstanceOf(Exception::class, $e);
        $this->assertSame(501, $e->httpCode());
    }
}
