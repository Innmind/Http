<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Exception\Http;

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
