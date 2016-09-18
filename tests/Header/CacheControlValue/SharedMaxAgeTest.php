<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\CacheControlValue;

use Innmind\Http\Header\{
    CacheControlValueInterface,
    CacheControlValue\SharedMaxAge
};

class SharedMaxAgeTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $h = new SharedMaxAge(42);

        $this->assertInstanceOf(CacheControlValueInterface::class, $h);
        $this->assertSame(42, $h->age());
        $this->assertSame('s-maxage=42', (string) $h);
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenAgeIsNegative()
    {
        new SharedMaxAge(-42);
    }
}
