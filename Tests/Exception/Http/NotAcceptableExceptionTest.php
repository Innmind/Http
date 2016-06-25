<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Exception\Http;

use Innmind\Http\Exception\Http\{
    NotAcceptableException,
    ExceptionInterface
};

class NotAcceptableExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $e = new NotAcceptableException;

        $this->assertInstanceOf(ExceptionInterface::class, $e);
        $this->assertSame(406, $e->httpCode());
    }
}
