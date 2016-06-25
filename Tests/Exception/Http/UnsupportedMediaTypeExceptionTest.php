<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Exception\Http;

use Innmind\Http\Exception\Http\{
    UnsupportedMediaTypeException,
    ExceptionInterface
};

class UnsupportedMediaTypeExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $e = new UnsupportedMediaTypeException;

        $this->assertInstanceOf(ExceptionInterface::class, $e);
        $this->assertSame(415, $e->httpCode());
    }
}
