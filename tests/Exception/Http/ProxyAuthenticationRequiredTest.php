<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    ProxyAuthenticationRequired,
    Exception
};
use PHPUnit\Framework\TestCase;

class ProxyAuthenticationRequiredTest extends TestCase
{
    public function testInterface()
    {
        $e = new ProxyAuthenticationRequired;

        $this->assertInstanceOf(Exception::class, $e);
        $this->assertSame(407, $e->httpCode());
    }
}
