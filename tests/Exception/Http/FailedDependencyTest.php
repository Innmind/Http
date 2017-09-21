<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    FailedDependency,
    Exception
};
use PHPUnit\Framework\TestCase;

class FailedDependencyTest extends TestCase
{
    public function testInterface()
    {
        $e = new FailedDependency;

        $this->assertInstanceOf(Exception::class, $e);
        $this->assertSame(424, $e->httpCode());
    }
}
