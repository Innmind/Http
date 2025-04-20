<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\CacheControlValue;

use Innmind\Http\Header\CacheControl\SharedMaxAge;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class SharedMaxAgeTest extends TestCase
{
    public function testInterface()
    {
        $h = SharedMaxAge::of(42);

        $this->assertInstanceOf(SharedMaxAge::class, $h);
        $this->assertSame(42, $h->age());
        $this->assertSame('s-maxage=42', $h->toString());
    }
}
