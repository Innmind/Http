<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    NotImplementedException,
    ExceptionInterface
};

class NotImplementedExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $e = new NotImplementedException;

        $this->assertInstanceOf(ExceptionInterface::class, $e);
        $this->assertSame(501, $e->httpCode());
    }
}
