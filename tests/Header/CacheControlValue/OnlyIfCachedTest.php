<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\CacheControlValue;

use Innmind\Http\Header\{
    CacheControlValueInterface,
    CacheControlValue\OnlyIfCached
};

class OnlyIfCachedTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $h = new OnlyIfCached;

        $this->assertInstanceOf(CacheControlValueInterface::class, $h);
        $this->assertSame('only-if-cached', (string) $h);
    }
}
