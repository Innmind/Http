<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    UnsupportedMediaTypeException,
    Exception
};
use PHPUnit\Framework\TestCase;

class UnsupportedMediaTypeExceptionTest extends TestCase
{
    public function testInterface()
    {
        $e = new UnsupportedMediaTypeException;

        $this->assertInstanceOf(Exception::class, $e);
        $this->assertSame(415, $e->httpCode());
    }
}
