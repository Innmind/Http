<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\CacheControlValue;

use Innmind\Http\Header\{
    CacheControlValue,
    CacheControlValue\MaxStale
};
use PHPUnit\Framework\TestCase;

class MaxStaleTest extends TestCase
{
    public function testInterface()
    {
        $h = new MaxStale(42);

        $this->assertInstanceOf(CacheControlValue::class, $h);
        $this->assertSame(42, $h->age());
        $this->assertSame('max-stale=42', $h->toString());
        $this->assertSame('max-stale', (new MaxStale(0))->toString());
    }

    /**
     * @expectedException Innmind\Http\Exception\DomainException
     */
    public function testThrowWhenAgeIsNegative()
    {
        new MaxStale(-42);
    }
}
