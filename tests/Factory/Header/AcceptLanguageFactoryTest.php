<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\AcceptLanguageFactory,
    Factory\HeaderFactory,
    Header\AcceptLanguage
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

    /**
     * @expectedException Innmind\Http\Exception\DomainException
     */
    public function testThrowWhenNotExpectedHeader()
    {
        (new AcceptLanguageFactory)(
            Str::of('foo'),
            Str::of(''),
        );
    }

    /**
     * @expectedException Innmind\Http\Exception\DomainException
     */
    public function testThrowWhenNotValid()
    {
        (new AcceptLanguageFactory)(
            Str::of('Accept-Language'),
            Str::of('@'),
        );
    }
}
