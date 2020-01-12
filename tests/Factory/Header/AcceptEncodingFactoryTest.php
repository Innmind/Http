<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\AcceptEncodingFactory,
    Factory\HeaderFactory,
    Header\AcceptEncoding
};
use Innmind\Immutable\Str;
use PHPUnit\Framework\TestCase;

class AcceptEncodingFactoryTest extends TestCase
{
    public function testMake()
    {
        $f = new AcceptEncodingFactory;

        $this->assertInstanceOf(HeaderFactory::class, $f);

        $h = ($f)(
            Str::of('Accept-Encoding'),
            Str::of('gzip, identity; q=0.5, *;q=0'),
        );

        $this->assertInstanceOf(AcceptEncoding::class, $h);
        $this->assertSame(
            'Accept-Encoding: gzip;q=1, identity;q=0.5, *;q=0',
            $h->toString(),
        );
    }

    /**
     * @expectedException Innmind\Http\Exception\DomainException
     */
    public function testThrowWhenNotExpectedHeader()
    {
        (new AcceptEncodingFactory)(
            Str::of('foo'),
            Str::of(''),
        );
    }

    /**
     * @expectedException Innmind\Http\Exception\DomainException
     */
    public function testThrowWhenNotValid()
    {
        (new AcceptEncodingFactory)(
            Str::of('Accept-Encoding'),
            Str::of('@'),
        );
    }
}
