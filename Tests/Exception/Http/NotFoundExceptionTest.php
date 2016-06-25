<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Exception\Http;

use Innmind\Http\Exception\Http\{
    NotFoundException,
    ExceptionInterface
};

class NotFoundExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $e = new NotFoundException;

        $this->assertInstanceOf(ExceptionInterface::class, $e);
        $this->assertSame(404, $e->httpCode());
    }
}
