<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    ProxyAuthenticationRequiredException,
    Exception
};
use PHPUnit\Framework\TestCase;

class ProxyAuthenticationRequiredExceptionTest extends TestCase
{
    public function testInterface()
    {
        $e = new ProxyAuthenticationRequiredException;

        $this->assertInstanceOf(Exception::class, $e);
        $this->assertSame(407, $e->httpCode());
    }
}
