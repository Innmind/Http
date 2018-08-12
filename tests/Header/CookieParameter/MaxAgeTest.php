<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\CookieParameter;

use Innmind\Http\{
    Header\CookieParameter\MaxAge,
    Header\Parameter,
    Exception\DomainException
};
use PHPUnit\Framework\TestCase;

class MaxAgeTest extends TestCase
{
    public function testInterface()
    {
        $maxAge = new MaxAge(1);

        $this->assertInstanceOf(Parameter::class, $maxAge);
        $this->assertSame('Max-Age=1', (string) $maxAge);

        $this->assertInstanceOf(Parameter::class, MaxAge::expire());
        $this->assertSame('Max-Age=-1', (string) MaxAge::expire());
    }

    public function testThrowWhenInvalidAge()
    {
        $this->expectException(DomainException::class);

        new MaxAge(0);
    }
}
