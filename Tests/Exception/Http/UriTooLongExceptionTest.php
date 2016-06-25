<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Exception\Http;

use Innmind\Http\Exception\Http\{
    UriTooLongException,
    ExceptionInterface
};

class UriTooLongExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $e = new UriTooLongException;

        $this->assertInstanceOf(ExceptionInterface::class, $e);
        $this->assertSame(414, $e->httpCode());
    }
}
