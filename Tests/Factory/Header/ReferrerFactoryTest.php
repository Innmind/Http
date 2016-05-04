<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Factory\Header;

use Innmind\Http\{
    Factory\Header\ReferrerFactory,
    Factory\HeaderFactoryInterface,
    Header\Referrer
};
use Innmind\Immutable\StringPrimitive as Str;

class ReferrerFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testMake()
    {
        $f = new ReferrerFactory;

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
    }
}
