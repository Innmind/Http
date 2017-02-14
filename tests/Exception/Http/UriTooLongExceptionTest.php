<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    UriTooLongException,
    ExceptionInterface
};
use PHPUnit\Framework\TestCase;

class UriTooLongExceptionTest extends TestCase
{
    public function testInterface()
    {
        $e = new UriTooLongException;

        $this->assertInstanceOf(ExceptionInterface::class, $e);
        $this->assertSame(414, $e->httpCode());
    }
}
