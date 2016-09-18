<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\CacheControlValue;

use Innmind\Http\Header\{
    CacheControlValueInterface,
    CacheControlValue\PublicCache
};

class PublicCacheTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $h = new PublicCache;

        $this->assertInstanceOf(CacheControlValueInterface::class, $h);
        $this->assertSame('public', (string) $h);
    }
}
