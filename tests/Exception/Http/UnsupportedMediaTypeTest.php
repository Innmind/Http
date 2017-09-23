<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    UnsupportedMediaType,
    Exception
};
use PHPUnit\Framework\TestCase;

class UnsupportedMediaTypeTest extends TestCase
{
    public function testInterface()
    {
        $e = new UnsupportedMediaType;

        $this->assertInstanceOf(Exception::class, $e);
        $this->assertSame(415, $e->httpCode());
    }
}
