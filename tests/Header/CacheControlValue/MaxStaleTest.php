<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\CacheControlValue;

use Innmind\Http\Header\CacheControl\MaxStale;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class MaxStaleTest extends TestCase
{
    public function testInterface()
    {
        $h = MaxStale::of(42);

        $this->assertInstanceOf(MaxStale::class, $h);
        $this->assertSame(42, $h->age());
        $this->assertSame('max-stale=42', $h->toString());
        $this->assertSame('max-stale', MaxStale::of(0)->toString());
    }
}
