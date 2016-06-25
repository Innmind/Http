<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Exception\Http;

use Innmind\Http\Exception\Http\{
    ImATeapotException,
    ExceptionInterface
};

class ImATeapotExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $e = new ImATeapotException;

        $this->assertInstanceOf(ExceptionInterface::class, $e);
        $this->assertSame(418, $e->httpCode());
    }
}
