<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Exception\Http;

use Innmind\Http\Exception\Http\{
    PreconditionRequiredException,
    ExceptionInterface
};

class PreconditionRequiredExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $e = new PreconditionRequiredException;

        $this->assertInstanceOf(ExceptionInterface::class, $e);
        $this->assertSame(428, $e->httpCode());
    }
}
