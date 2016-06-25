<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Exception\Http;

use Innmind\Http\Exception\Http\{
    ExpectationFailedException,
    ExceptionInterface
};

class ExpectationFailedExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $e = new ExpectationFailedException;

        $this->assertInstanceOf(ExceptionInterface::class, $e);
        $this->assertSame(417, $e->httpCode());
    }
}
