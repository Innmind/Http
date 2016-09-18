<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    InsufficientStorageException,
    ExceptionInterface
};

class InsufficientStorageExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $e = new InsufficientStorageException;

        $this->assertInstanceOf(ExceptionInterface::class, $e);
        $this->assertSame(507, $e->httpCode());
    }
}
