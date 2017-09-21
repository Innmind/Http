<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\CacheControlValue;

use Innmind\Http\Header\{
    CacheControlValue,
    CacheControlValue\ProxyRevalidate
};
use PHPUnit\Framework\TestCase;

class ProxyRevalidateTest extends TestCase
{
    public function testInterface()
    {
        $h = new ProxyRevalidate;

        $this->assertInstanceOf(CacheControlValue::class, $h);
        $this->assertSame('proxy-revalidate', (string) $h);
    }
}
