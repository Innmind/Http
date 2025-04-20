<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\CookieParameter;

use Innmind\Http\Header\SetCookie\Directive;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class HttpOnlyTest extends TestCase
{
    public function testInterface()
    {
        $httpOnly = Directive::httpOnly;

        $this->assertSame('HttpOnly', $httpOnly->toParameter()->toString());
    }
}
