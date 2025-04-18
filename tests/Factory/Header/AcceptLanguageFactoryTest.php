<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\AcceptLanguageFactory,
    Factory\HeaderFactory,
    Header\AcceptLanguage,
};
use Innmind\Immutable\Str;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class AcceptLanguageFactoryTest extends TestCase
{
    public function testMake()
    {
        $f = new AcceptLanguageFactory;

        $this->assertInstanceOf(HeaderFactory::class, $f);

        $h = ($f)(
            Str::of('Accept-Language'),
            Str::of('da, en-gb;q=0.8, en;q=0.7'),
        )->match(
            static fn($header) => $header,
            static fn() => null,
        );

        $this->assertInstanceOf(AcceptLanguage::class, $h);
        $this->assertSame(
            'Accept-Language: da;q=1, en-gb;q=0.8, en;q=0.7',
            $h->toString(),
        );
    }

    public function testReturnNothingWhenNotExpectedHeader()
    {
        $this->assertNull((new AcceptLanguageFactory)(
            Str::of('foo'),
            Str::of(''),
        )->match(
            static fn($header) => $header,
            static fn() => null,
        ));
    }

    public function testReturnNothingWhenNotValid()
    {
        $this->assertNull((new AcceptLanguageFactory)(
            Str::of('Accept-Language'),
            Str::of('@'),
        )->match(
            static fn($header) => $header,
            static fn() => null,
        ));
    }
}
