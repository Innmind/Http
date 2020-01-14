<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header\CacheControlValue;

use Innmind\Http\{
    Header\CacheControlValue,
    Header\CacheControlValue\NoCache,
    Exception\DomainException,
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

    public function testThrowWhenAgeIsNegative()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('foo-bar');

        new NoCache('foo-bar');
    }
}
