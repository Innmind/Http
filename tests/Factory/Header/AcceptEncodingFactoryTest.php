<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\AcceptEncodingFactory,
    Factory\HeaderFactory,
    Header\AcceptEncoding,
    Exception\DomainException,
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

    public function testThrowWhenNotExpectedHeader()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('foo');

        (new AcceptEncodingFactory)(
            Str::of('foo'),
            Str::of(''),
        );
    }

    public function testThrowWhenNotValid()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('@');

        (new AcceptEncodingFactory)(
            Str::of('Accept-Encoding'),
            Str::of('@'),
        );
    }
}
