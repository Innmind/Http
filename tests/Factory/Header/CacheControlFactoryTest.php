<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\CacheControlFactory,
    Factory\HeaderFactory,
    Header\CacheControl
};
use Innmind\Immutable\Str;
use PHPUnit\Framework\TestCase;

class CacheControlFactoryTest extends TestCase
{
    public function testMake()
    {
        $f = new CacheControlFactory;

        $this->assertInstanceOf(HeaderFactory::class, $f);

        $h = $f->make(
            new Str('Cache-Control'),
            new Str('no-cache="field", no-store, max-age=42, max-stale=42, min-fresh=42, no-transform, only-if-cached, public, private="field", must-revalidate, proxy-revalidate, s-maxage=42')
        );

        $this->assertInstanceOf(CacheControl::class, $h);
        $this->assertSame(
            'Cache-Control : no-cache="field", no-store, max-age=42, max-stale=42, min-fresh=42, no-transform, only-if-cached, public, private="field", must-revalidate, proxy-revalidate, s-maxage=42',
            (string) $h
        );
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenNotExpectedHeader()
    {
        (new CacheControlFactory)->make(
            new Str('foo'),
            new Str('')
        );
    }
}
