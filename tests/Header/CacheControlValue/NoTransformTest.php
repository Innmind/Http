<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\CacheControlValue;

use Innmind\Http\Header\{
    CacheControlValue,
    CacheControlValue\NoTransform
};
use PHPUnit\Framework\TestCase;

class NoTransformTest extends TestCase
{
    public function testInterface()
    {
        $h = new NoTransform;

        $this->assertInstanceOf(CacheControlValue::class, $h);
        $this->assertSame('no-transform', $h->toString());
    }
}
