<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\CookieParameter;

use Innmind\Http\Header\SetCookie\MaxAge;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class MaxAgeTest extends TestCase
{
    public function testInterface()
    {
        $maxAge = MaxAge::of(1);

        $this->assertSame('Max-Age=1', $maxAge->toParameter()->toString());

        $this->assertSame('Max-Age=-1', MaxAge::expire()->toParameter()->toString());
    }
}
