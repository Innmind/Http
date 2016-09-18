<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    GoneException,
    ExceptionInterface
};

class GoneExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $e = new GoneException;

        $this->assertInstanceOf(ExceptionInterface::class, $e);
        $this->assertSame(410, $e->httpCode());
    }
}
