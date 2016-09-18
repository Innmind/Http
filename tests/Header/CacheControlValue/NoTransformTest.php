<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\CacheControlValue;

use Innmind\Http\Header\{
    CacheControlValueInterface,
    CacheControlValue\NoTransform
};

class NoTransformTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $h = new NoTransform;

        $this->assertInstanceOf(CacheControlValueInterface::class, $h);
        $this->assertSame('no-transform', (string) $h);
    }
}
