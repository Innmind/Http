<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    UnauthorizedException,
    ExceptionInterface
};

class UnauthorizedExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $e = new UnauthorizedException;

        $this->assertInstanceOf(ExceptionInterface::class, $e);
        $this->assertSame(401, $e->httpCode());
    }
}
