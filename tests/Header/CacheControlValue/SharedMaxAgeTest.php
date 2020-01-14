<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\CacheControlValue;

use Innmind\Http\{
    Header\CacheControlValue,
    Header\CacheControlValue\SharedMaxAge,
    Exception\DomainException,
};
use PHPUnit\Framework\TestCase;

class SharedMaxAgeTest extends TestCase
{
    public function testInterface()
    {
        $h = new SharedMaxAge(42);

        $this->assertInstanceOf(CacheControlValue::class, $h);
        $this->assertSame(42, $h->age());
        $this->assertSame('s-maxage=42', $h->toString());
    }

    public function testThrowWhenAgeIsNegative()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('-42');

        new SharedMaxAge(-42);
    }
}
