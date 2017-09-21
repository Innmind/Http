<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    PreconditionFailed,
    Exception
};
use PHPUnit\Framework\TestCase;

class PreconditionFailedTest extends TestCase
{
    public function testInterface()
    {
        $e = new PreconditionFailed;

        $this->assertInstanceOf(Exception::class, $e);
        $this->assertSame(412, $e->httpCode());
    }
}
