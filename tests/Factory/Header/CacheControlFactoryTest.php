<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\CacheControlFactory,
    Factory\HeaderFactory,
    Header\CacheControl,
    Exception\DomainException,
};
use Innmind\Immutable\Str;
use PHPUnit\Framework\TestCase;

class CacheControlFactoryTest extends TestCase
{
    public function testMake()
    {
        $f = new CacheControlFactory;

        $this->assertInstanceOf(HeaderFactory::class, $f);

        $h = ($f)(
            Str::of('Cache-Control'),
            Str::of('no-cache="field", no-store, max-age=42, max-stale=42, min-fresh=42, no-transform, only-if-cached, public, private="field", must-revalidate, proxy-revalidate, s-maxage=42, immutable'),
        );

        $this->assertInstanceOf(CacheControl::class, $h);
        $this->assertSame(
            'Cache-Control: no-cache="field", no-store, max-age=42, max-stale=42, min-fresh=42, no-transform, only-if-cached, public, private="field", must-revalidate, proxy-revalidate, s-maxage=42, immutable',
            $h->toString(),
        );
    }

    public function testThrowWhenNotExpectedHeader()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('foo');

        (new CacheControlFactory)(
            Str::of('foo'),
            Str::of(''),
        );
    }
}
