<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\AcceptCharsetFactory,
    Factory\HeaderFactory,
    Header\AcceptCharset
};
use Innmind\Immutable\Str;
use PHPUnit\Framework\TestCase;

class AcceptCharsetFactoryTest extends TestCase
{
    public function testMake()
    {
        $f = new AcceptCharsetFactory;

        $this->assertInstanceOf(HeaderFactory::class, $f);

        $h = ($f)(
            Str::of('Accept-Charset'),
            Str::of('iso-8859-5, unicode-1-1;q=0.8'),
        );

        $this->assertInstanceOf(AcceptCharset::class, $h);
        $this->assertSame(
            'Accept-Charset: iso-8859-5;q=1, unicode-1-1;q=0.8',
            $h->toString(),
        );
    }

    /**
     * @expectedException Innmind\Http\Exception\DomainException
     */
    public function testThrowWhenNotExpectedHeader()
    {
        (new AcceptCharsetFactory)(
            Str::of('foo'),
            Str::of(''),
        );
    }

    /**
     * @expectedException Innmind\Http\Exception\DomainException
     */
    public function testThrowWhenInvalidValue()
    {
        (new AcceptCharsetFactory)(
            Str::of('Accept-Charset'),
            Str::of('@'),
        );
    }
}
