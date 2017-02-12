<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\AcceptLanguageFactory,
    Factory\HeaderFactoryInterface,
    Header\AcceptLanguage
};
use Innmind\Immutable\StringPrimitive as Str;
use PHPUnit\Framework\TestCase;

class AcceptLanguageFactoryTest extends TestCase
{
    public function testMake()
    {
        $f = new AcceptLanguageFactory;

        $this->assertInstanceOf(HeaderFactoryInterface::class, $f);

        $h = $f->make(
            new Str('Accept-Language'),
            new Str('da, en-gb;q=0.8, en;q=0.7')
        );

        $this->assertInstanceOf(AcceptLanguage::class, $h);
        $this->assertSame(
            'Accept-Language : da;q=1, en-gb;q=0.8, en;q=0.7',
            (string) $h
        );
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenNotExpectedHeader()
    {
        (new AcceptLanguageFactory)->make(
            new Str('foo'),
            new Str('')
        );
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenNotValid()
    {
        (new AcceptLanguageFactory)->make(
            new Str('Accept-Language'),
            new Str('@')
        );
    }
}
