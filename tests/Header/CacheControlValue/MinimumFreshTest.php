<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\CacheControlValue;

use Innmind\Http\{
    Header\CacheControlValue,
    Header\CacheControlValue\MinimumFresh,
    Exception\DomainException,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class MinimumFreshTest extends TestCase
{
    public function testInterface()
    {
        $h = new MinimumFresh(42);

        $this->assertInstanceOf(CacheControlValue::class, $h);
        $this->assertSame(42, $h->age());
        $this->assertSame('min-fresh=42', $h->toString());
    }

    public function testThrowWhenAgeIsNegative()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('-42');

        new MinimumFresh(-42);
    }
}
