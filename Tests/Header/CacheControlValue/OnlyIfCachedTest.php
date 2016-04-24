<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Header\CacheControlValue;

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
