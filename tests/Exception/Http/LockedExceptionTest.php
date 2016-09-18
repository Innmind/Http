<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    LockedException,
    ExceptionInterface
};

class LockedExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $e = new LockedException;

        $this->assertInstanceOf(ExceptionInterface::class, $e);
        $this->assertSame(423, $e->httpCode());
    }
}
