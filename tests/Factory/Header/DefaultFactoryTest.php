<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\DefaultFactory,
    Factory\Header\ReferrerFactory,
    Factory\HeaderFactoryInterface,
    Header\Referrer,
    Header\Header,
    Header\HeaderInterface
};
use Innmind\Immutable\{
    StringPrimitive as Str,
    Map
};

class DefaultFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testMake()
    {
        $f = new DefaultFactory(
            (new Map('string', HeaderFactoryInterface::class))
                ->put('referer', new ReferrerFactory)
        );

        $this->assertInstanceOf(HeaderFactoryInterface::class, $f);

        $h = $f->make(
            new Str('Referer'),
            new Str('http://www.w3.org/hypertext/DataSources/Overview.html')
        );

        $this->assertInstanceOf(Referrer::class, $h);
        $this->assertSame(
            'Referer : http://www.w3.org/hypertext/DataSources/Overview.html',
            (string) $h
        );

        $h = $f->make(
            new Str('Cache-Control'),
            new Str('no-cache')
        );

        $this->assertInstanceOf(HeaderInterface::class, $h);
        $this->assertSame('Cache-Control : no-cache', (string) $h);
    }
}
