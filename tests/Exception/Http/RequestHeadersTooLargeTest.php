<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    RequestHeadersTooLarge,
    Exception
};
use PHPUnit\Framework\TestCase;

class RequestHeadersTooLargeTest extends TestCase
{
    public function testInterface()
    {
        $e = new RequestHeadersTooLarge;

        $this->assertInstanceOf(Exception::class, $e);
        $this->assertSame(431, $e->httpCode());
    }
}
