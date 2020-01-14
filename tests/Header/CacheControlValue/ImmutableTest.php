<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\CacheControlValue;

use Innmind\Http\Header\{
    CacheControlValue,
    CacheControlValue\Immutable
};
use PHPUnit\Framework\TestCase;

class ImmutableTest extends TestCase
{
    public function testInterface()
    {
        $h = new Immutable;

        $this->assertInstanceOf(CacheControlValue::class, $h);
        $this->assertSame('immutable', $h->toString());
    }
}
