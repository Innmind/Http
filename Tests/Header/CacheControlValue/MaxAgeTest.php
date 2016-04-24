<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Header\CacheControlValue;

use Innmind\Http\Header\{
    CacheControlValueInterface,
    CacheControlValue\MaxAge
};

class MaxAgeTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $h = new MaxAge(42);

        $this->assertInstanceOf(CacheControlValueInterface::class, $h);
        $this->assertSame(42, $h->age());
        $this->assertSame('max-age=42', (string) $h);
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenAgeIsNegative()
    {
        new MaxAge(-42);
    }
}
