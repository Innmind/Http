<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\CacheControlValue;

use Innmind\Http\Header\{
    CacheControlValueInterface,
    CacheControlValue\MaxStale
};

class MaxStaleTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $h = new MaxStale(42);

        $this->assertInstanceOf(CacheControlValueInterface::class, $h);
        $this->assertSame(42, $h->age());
        $this->assertSame('max-stale=42', (string) $h);
        $this->assertSame('max-stale', (string) new MaxStale(0));
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenAgeIsNegative()
    {
        new MaxStale(-42);
    }
}
