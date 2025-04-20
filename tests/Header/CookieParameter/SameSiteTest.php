<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\CookieParameter;

use Innmind\Http\Header\SetCookie\Directive;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class SameSiteTest extends TestCase
{
    public function testInterface()
    {
        $sameSite = Directive::strictSameSite;

        $this->assertSame('SameSite=Strict', $sameSite->toParameter()->toString());

        $sameSite = Directive::laxSameSite;

        $this->assertSame('SameSite=Lax', $sameSite->toParameter()->toString());
    }
}
