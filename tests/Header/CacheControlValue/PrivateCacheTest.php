<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\CacheControlValue;

use Innmind\Http\Header\{
    CacheControlValue,
    CacheControlValue\PrivateCache
};
use PHPUnit\Framework\TestCase;

class PrivateCacheTest extends TestCase
{
    public function testInterface()
    {
        $h = new PrivateCache('field');

        $this->assertInstanceOf(CacheControlValue::class, $h);
        $this->assertSame('field', $h->field());
        $this->assertSame('private="field"', $h->toString());
        $this->assertSame('private', (new PrivateCache(''))->toString());
    }

    /**
     * @expectedException Innmind\Http\Exception\DomainException
     */
    public function testThrowWhenAgeIsNegative()
    {
        new PrivateCache('foo-bar');
    }
}
