<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Factory\Header;

use Innmind\Http\{
    Factory\Header\CacheControlFactory,
    Factory\HeaderFactoryInterface,
    Header\CacheControl
};
use Innmind\Immutable\StringPrimitive as Str;

class CacheControlFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testMake()
    {
        $f = new CacheControlFactory;

        $this->assertInstanceOf(HeaderFactoryInterface::class, $f);

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
}
