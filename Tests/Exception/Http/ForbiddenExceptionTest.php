<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Exception\Http;

use Innmind\Http\Exception\Http\{
    ForbiddenException,
    ExceptionInterface
};

class ForbiddenExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $e = new ForbiddenException;

        $this->assertInstanceOf(ExceptionInterface::class, $e);
        $this->assertSame(403, $e->httpCode());
    }
}
