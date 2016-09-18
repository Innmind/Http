<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    RequestHeadersTooLargeException,
    ExceptionInterface
};

class RequestHeadersTooLargeExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $e = new RequestHeadersTooLargeException;

        $this->assertInstanceOf(ExceptionInterface::class, $e);
        $this->assertSame(431, $e->httpCode());
    }
}
