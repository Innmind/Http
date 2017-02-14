<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\CacheControlValue;

use Innmind\Http\Header\{
    CacheControlValueInterface,
    CacheControlValue\ProxyRevalidate
};
use PHPUnit\Framework\TestCase;

class ProxyRevalidateTest extends TestCase
{
    public function testInterface()
    {
        $h = new ProxyRevalidate;

        $this->assertInstanceOf(CacheControlValueInterface::class, $h);
        $this->assertSame('proxy-revalidate', (string) $h);
    }
}
