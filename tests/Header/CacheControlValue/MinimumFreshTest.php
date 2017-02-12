<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\CacheControlValue;

use Innmind\Http\Header\{
    CacheControlValueInterface,
    CacheControlValue\MinimumFresh
};
use PHPUnit\Framework\TestCase;

class MinimumFreshTest extends TestCase
{
    public function testInterface()
    {
        $h = new MinimumFresh(42);

        $this->assertInstanceOf(CacheControlValueInterface::class, $h);
        $this->assertSame(42, $h->age());
        $this->assertSame('min-fresh=42', (string) $h);
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenAgeIsNegative()
    {
        new MinimumFresh(-42);
    }
}
