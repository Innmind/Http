<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\CookieParameter;

use Innmind\Http\{
    Header\CookieParameter\MaxAge,
    Header\Parameter,
    Exception\DomainException
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class MaxAgeTest extends TestCase
{
    public function testInterface()
    {
        $maxAge = new MaxAge(1);

        $this->assertInstanceOf(Parameter::class, $maxAge);
        $this->assertSame('Max-Age=1', $maxAge->toString());

        $this->assertInstanceOf(Parameter::class, MaxAge::expire());
        $this->assertSame('Max-Age=-1', MaxAge::expire()->toString());
    }

    public function testThrowWhenInvalidAge()
    {
        $this->expectException(DomainException::class);

        new MaxAge(0);
    }
}
