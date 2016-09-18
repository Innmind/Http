<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    MisdirectedRequestException,
    ExceptionInterface
};

class MisdirectedRequestExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $e = new MisdirectedRequestException;

        $this->assertInstanceOf(ExceptionInterface::class, $e);
        $this->assertSame(421, $e->httpCode());
    }
}
