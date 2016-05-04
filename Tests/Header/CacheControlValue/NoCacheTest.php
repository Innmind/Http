<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Header\CacheControlValue;

use Innmind\Http\Header\{
    CacheControlValueInterface,
    CacheControlValue\NoCache
};

class NoCacheTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $h = new NoCache('field');

        $this->assertInstanceOf(CacheControlValueInterface::class, $h);
        $this->assertSame('field', $h->field());
        $this->assertSame('no-cache="field"', (string) $h);
        $this->assertSame('no-cache', (string) new NoCache(''));
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenAgeIsNegative()
    {
        new NoCache('foo-bar');
    }
}
