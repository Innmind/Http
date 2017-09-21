<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    PayloadTooLarge,
    Exception
};
use PHPUnit\Framework\TestCase;

class PayloadTooLargeTest extends TestCase
{
    public function testInterface()
    {
        $e = new PayloadTooLarge;

        $this->assertInstanceOf(Exception::class, $e);
        $this->assertSame(413, $e->httpCode());
    }
}
