<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\CacheControlValue;

use Innmind\Http\Header\CacheControl\PrivateCache;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class PrivateCacheTest extends TestCase
{
    public function testInterface()
    {
        $h = PrivateCache::maybe('field')->match(
            static fn($value) => $value,
            static fn() => null,
        );

        $this->assertInstanceOf(PrivateCache::class, $h);
        $this->assertSame('field', $h->field());
        $this->assertSame('private="field"', $h->toString());
        $this->assertSame('private', PrivateCache::maybe('')->match(
            static fn($value) => $value->toString(),
            static fn() => null,
        ));
    }

    public function testThrowWhenAgeIsNegative()
    {
        $this->assertNull(PrivateCache::maybe('foo-bar')->match(
            static fn($value) => $value,
            static fn() => null,
        ));
    }
}
