<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\CookieParameter;

use Innmind\Http\Header\{
    CookieParameter\Secure,
    Parameter
};
use PHPUnit\Framework\TestCase;

class SecureTest extends TestCase
{
    public function testInterface()
    {
        $secure = new Secure;

        $this->assertInstanceOf(Parameter::class, $secure);
        $this->assertSame('Secure', $secure->toString());
    }
}
