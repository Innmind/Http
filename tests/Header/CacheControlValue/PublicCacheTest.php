<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\CacheControlValue;

use Innmind\Http\Header\{
    CacheControlValue,
    CacheControlValue\PublicCache
};
use PHPUnit\Framework\TestCase;

class PublicCacheTest extends TestCase
{
    public function testInterface()
    {
        $h = new PublicCache;

        $this->assertInstanceOf(CacheControlValue::class, $h);
        $this->assertSame('public', $h->toString());
    }
}
