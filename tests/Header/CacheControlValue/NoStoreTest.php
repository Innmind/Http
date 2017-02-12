<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\CacheControlValue;

use Innmind\Http\Header\{
    CacheControlValueInterface,
    CacheControlValue\NoStore
};
use PHPUnit\Framework\TestCase;

class NoStoreTest extends TestCase
{
    public function testInterface()
    {
        $h = new NoStore;

        $this->assertInstanceOf(CacheControlValueInterface::class, $h);
        $this->assertSame('no-store', (string) $h);
    }
}
