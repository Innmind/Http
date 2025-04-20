<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\CacheControlValue;

use Innmind\Http\Header\CacheControl\MinimumFresh;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class MinimumFreshTest extends TestCase
{
    public function testInterface()
    {
        $h = MinimumFresh::of(42);

        $this->assertInstanceOf(MinimumFresh::class, $h);
        $this->assertSame(42, $h->age());
        $this->assertSame('min-fresh=42', $h->toString());
    }
}
