<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Header\CacheControlValue;

use Innmind\Http\Header\{
    CacheControlValueInterface,
    CacheControlValue\MustRevalidate
};

class MustRevalidateTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $h = new MustRevalidate;

        $this->assertInstanceOf(CacheControlValueInterface::class, $h);
        $this->assertSame('must-revalidate', (string) $h);
    }
}
