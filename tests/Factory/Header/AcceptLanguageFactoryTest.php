<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\AcceptLanguageFactory,
    Factory\HeaderFactory,
    Header\AcceptLanguage,
    Exception\DomainException,
};
use Innmind\Immutable\Str;
use PHPUnit\Framework\TestCase;

class AcceptLanguageFactoryTest extends TestCase
{
    public function testMake()
    {
        $f = new AcceptLanguageFactory;

        $this->assertInstanceOf(HeaderFactory::class, $f);

        $h = ($f)(
            Str::of('Accept-Language'),
            Str::of('da, en-gb;q=0.8, en;q=0.7'),
        );

        $this->assertInstanceOf(AcceptLanguage::class, $h);
        $this->assertSame(
            'Accept-Language: da;q=1, en-gb;q=0.8, en;q=0.7',
            $h->toString(),
        );
    }

    public function testThrowWhenNotExpectedHeader()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('foo');

        (new AcceptLanguageFactory)(
            Str::of('foo'),
            Str::of(''),
        );
    }

    public function testThrowWhenNotValid()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('@');

        (new AcceptLanguageFactory)(
            Str::of('Accept-Language'),
            Str::of('@'),
        );
    }
}
