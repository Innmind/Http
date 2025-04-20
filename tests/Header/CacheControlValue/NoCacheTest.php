<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\CacheControlValue;

use Innmind\Http\Header\CacheControl\NoCache;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class NoCacheTest extends TestCase
{
    public function testInterface()
    {
        $h = NoCache::maybe('field')->match(
            static fn($value) => $value,
            static fn() => null,
        );

        $this->assertInstanceOf(NoCache::class, $h);
        $this->assertSame('field', $h->field());
        $this->assertSame('no-cache="field"', $h->toString());
        $this->assertSame('no-cache', NoCache::maybe('')->match(
            static fn($value) => $value->toString(),
            static fn() => null,
        ));
    }

    public function testReturnNothingWhenAgeIsNegative()
    {
        $this->assertNull(NoCache::maybe('foo-bar')->match(
            static fn($value) => $value,
            static fn() => null,
        ));
    }
}
