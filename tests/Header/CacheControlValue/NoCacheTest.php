<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\CacheControlValue;

use Innmind\Http\Header\{
    CacheControlValue,
    CacheControlValue\NoCache
};
use PHPUnit\Framework\TestCase;

class NoCacheTest extends TestCase
{
    public function testInterface()
    {
        $h = new NoCache('field');

        $this->assertInstanceOf(CacheControlValue::class, $h);
        $this->assertSame('field', $h->field());
        $this->assertSame('no-cache="field"', $h->toString());
        $this->assertSame('no-cache', (new NoCache(''))->toString());
    }

    /**
     * @expectedException Innmind\Http\Exception\DomainException
     */
    public function testThrowWhenAgeIsNegative()
    {
        new NoCache('foo-bar');
    }
}
