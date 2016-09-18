<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\CacheControlValue;

use Innmind\Http\Header\{
    CacheControlValueInterface,
    CacheControlValue\ProxyRevalidate
};

class ProxyRevalidateTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $h = new ProxyRevalidate;

        $this->assertInstanceOf(CacheControlValueInterface::class, $h);
        $this->assertSame('proxy-revalidate', (string) $h);
    }
}
