<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Exception\Http;

use Innmind\Http\Exception\Http\{
    FailedDependencyException,
    ExceptionInterface
};

class FailedDependencyExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $e = new FailedDependencyException;

        $this->assertInstanceOf(ExceptionInterface::class, $e);
        $this->assertSame(424, $e->httpCode());
    }
}
