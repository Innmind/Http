<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\CookieParameter;

use Innmind\Http\Header\SetCookie\Directive;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class SecureTest extends TestCase
{
    public function testInterface()
    {
        $secure = Directive::secure;

        $this->assertSame('Secure', $secure->toParameter()->toString());
    }
}
