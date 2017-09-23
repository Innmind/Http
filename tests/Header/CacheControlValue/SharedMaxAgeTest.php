<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\CacheControlValue;

use Innmind\Http\Header\{
    CacheControlValue,
    CacheControlValue\SharedMaxAge
};
use PHPUnit\Framework\TestCase;

class SharedMaxAgeTest extends TestCase
{
    public function testInterface()
    {
        $h = new SharedMaxAge(42);

        $this->assertInstanceOf(CacheControlValue::class, $h);
        $this->assertSame(42, $h->age());
        $this->assertSame('s-maxage=42', (string) $h);
    }

    /**
     * @expectedException Innmind\Http\Exception\DomainException
     */
    public function testThrowWhenAgeIsNegative()
    {
        new SharedMaxAge(-42);
    }
}
