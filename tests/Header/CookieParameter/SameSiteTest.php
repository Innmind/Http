<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\CookieParameter;

use Innmind\Http\Header\{
    CookieParameter\SameSite,
    Parameter
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class SameSiteTest extends TestCase
{
    public function testInterface()
    {
        $sameSite = SameSite::strict();

        $this->assertInstanceOf(Parameter::class, $sameSite);
        $this->assertSame('SameSite=Strict', $sameSite->toString());

        $sameSite = SameSite::lax();

        $this->assertInstanceOf(Parameter::class, $sameSite);
        $this->assertSame('SameSite=Lax', $sameSite->toString());
    }
}
