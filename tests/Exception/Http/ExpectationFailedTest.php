<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    ExpectationFailed,
    Exception
};
use PHPUnit\Framework\TestCase;

class ExpectationFailedTest extends TestCase
{
    public function testInterface()
    {
        $e = new ExpectationFailed;

        $this->assertInstanceOf(Exception::class, $e);
        $this->assertSame(417, $e->httpCode());
    }
}
