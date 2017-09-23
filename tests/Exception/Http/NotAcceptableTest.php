<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    NotAcceptable,
    Exception
};
use PHPUnit\Framework\TestCase;

class NotAcceptableTest extends TestCase
{
    public function testInterface()
    {
        $e = new NotAcceptable;

        $this->assertInstanceOf(Exception::class, $e);
        $this->assertSame(406, $e->httpCode());
    }
}
