<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Header\CacheControlValue;

use Innmind\Http\Header\{
    CacheControlValueInterface,
    CacheControlValue\PrivateCache
};

class PrivateCacheTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $h = new PrivateCache('field');

        $this->assertInstanceOf(CacheControlValueInterface::class, $h);
        $this->assertSame('field', $h->field());
        $this->assertSame('private="field"', (string) $h);
        $this->assertSame('private', (string) new PrivateCache(''));
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenAgeIsNegative()
    {
        new PrivateCache('foo-bar');
    }
}
