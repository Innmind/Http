<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Exception\Http;

use Innmind\Http\Exception\Http\{
    ProxyAuthenticationRequiredException,
    ExceptionInterface
};

class ProxyAuthenticationRequiredExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $e = new ProxyAuthenticationRequiredException;

        $this->assertInstanceOf(ExceptionInterface::class, $e);
        $this->assertSame(407, $e->httpCode());
    }
}
