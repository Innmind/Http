<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\CacheControlValue;

use Innmind\Http\Header\{
    CacheControlValue,
    CacheControlValue\OnlyIfCached
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class OnlyIfCachedTest extends TestCase
{
    public function testInterface()
    {
        $h = new OnlyIfCached;

        $this->assertInstanceOf(CacheControlValue::class, $h);
        $this->assertSame('only-if-cached', $h->toString());
    }
}
