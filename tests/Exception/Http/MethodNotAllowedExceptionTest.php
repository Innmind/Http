<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    MethodNotAllowedException,
    ExceptionInterface
};

class MethodNotAllowedExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $e = new MethodNotAllowedException;

        $this->assertInstanceOf(ExceptionInterface::class, $e);
        $this->assertSame(405, $e->httpCode());
    }
}
