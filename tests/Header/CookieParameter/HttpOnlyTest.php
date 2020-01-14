<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\CookieParameter;

use Innmind\Http\Header\{
    CookieParameter\HttpOnly,
    Parameter
};
use PHPUnit\Framework\TestCase;

class HttpOnlyTest extends TestCase
{
    public function testInterface()
    {
        $httpOnly = new HttpOnly;

        $this->assertInstanceOf(Parameter::class, $httpOnly);
        $this->assertSame('HttpOnly', $httpOnly->toString());
    }
}
