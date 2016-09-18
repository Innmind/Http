<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    ConflictException,
    ExceptionInterface
};

class ConflictExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $e = new ConflictException;

        $this->assertInstanceOf(ExceptionInterface::class, $e);
        $this->assertSame(409, $e->httpCode());
    }
}