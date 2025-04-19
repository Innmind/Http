<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\AcceptCharsetFactory,
    Header\AcceptCharset,
};
use Innmind\Immutable\Str;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class AcceptCharsetFactoryTest extends TestCase
{
    public function testMake()
    {
        $f = new AcceptCharsetFactory;

        $h = ($f)(
            Str::of('Accept-Charset'),
            Str::of('iso-8859-5, unicode-1-1;q=0.8'),
        )->match(
            static fn($header) => $header,
            static fn() => null,
        );

        $this->assertInstanceOf(AcceptCharset::class, $h);
        $this->assertSame(
            'Accept-Charset: iso-8859-5;q=1, unicode-1-1;q=0.8',
            $h->toString(),
        );
    }

    public function testReturnNothingWhenNotExpectedHeader()
    {
        $this->assertNull((new AcceptCharsetFactory)(
            Str::of('foo'),
            Str::of(''),
        )->match(
            static fn($header) => $header,
            static fn() => null,
        ));
    }

    public function testReturnNothingWhenInvalidValue()
    {
        $this->assertNull((new AcceptCharsetFactory)(
            Str::of('Accept-Charset'),
            Str::of('@'),
        )->match(
            static fn($header) => $header,
            static fn() => null,
        ));
    }
}
