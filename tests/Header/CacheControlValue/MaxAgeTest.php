<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\CacheControlValue;

use Innmind\Http\Header\CacheControl\MaxAge;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class MaxAgeTest extends TestCase
{
    public function testInterface()
    {
        $h = MaxAge::of(42);

        $this->assertInstanceOf(MaxAge::class, $h);
        $this->assertSame(42, $h->age());
        $this->assertSame('max-age=42', $h->toString());
    }
}
