<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Exception\Http;

use Innmind\Http\Exception\Http\{
    BadRequestException,
    ExceptionInterface
};

class BadRequestExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $e = new BadRequestException;

        $this->assertInstanceOf(ExceptionInterface::class, $e);
        $this->assertSame(400, $e->httpCode());
    }
}
