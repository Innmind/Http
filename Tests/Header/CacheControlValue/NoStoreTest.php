<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Header\CacheControlValue;

use Innmind\Http\Header\{
    CacheControlValueInterface,
    CacheControlValue\NoStore
};

class NoStoreTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $h = new NoStore;

        $this->assertInstanceOf(CacheControlValueInterface::class, $h);
        $this->assertSame('no-store', (string) $h);
    }
}
