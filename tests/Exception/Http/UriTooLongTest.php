<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    UriTooLong,
    Exception
};
use PHPUnit\Framework\TestCase;

class UriTooLongTest extends TestCase
{
    public function testInterface()
    {
        $e = new UriTooLong;

        $this->assertInstanceOf(Exception::class, $e);
        $this->assertSame(414, $e->httpCode());
    }
}
