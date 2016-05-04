<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Factory\Header;

use Innmind\Http\{
    Factory\Header\AcceptEncodingFactory,
    Factory\HeaderFactoryInterface,
    Header\AcceptEncoding
};
use Innmind\Immutable\StringPrimitive as Str;

class AcceptEncodingFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testMake()
    {
        $f = new AcceptEncodingFactory;

        $this->assertInstanceOf(HeaderFactoryInterface::class, $f);

        $h = $f->make(
            new Str('Accept-Encoding'),
            new Str('gzip, identity; q=0.5, *;q=0')
        );

        $this->assertInstanceOf(AcceptEncoding::class, $h);
        $this->assertSame(
            'Accept-Encoding : gzip;q=1, identity;q=0.5, *;q=0',
            (string) $h
        );
    }
}
