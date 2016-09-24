<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\AcceptCharsetFactory,
    Factory\HeaderFactoryInterface,
    Header\AcceptCharset
};
use Innmind\Immutable\StringPrimitive as Str;

class AcceptCharsetFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testMake()
    {
        $f = new AcceptCharsetFactory;

        $this->assertInstanceOf(HeaderFactoryInterface::class, $f);

        $h = $f->make(
            new Str('Accept-Charset'),
            new Str('iso-8859-5, unicode-1-1;q=0.8')
        );

        $this->assertInstanceOf(AcceptCharset::class, $h);
        $this->assertSame(
            'Accept-Charset : iso-8859-5;q=1, unicode-1-1;q=0.8',
            (string) $h
        );
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenNotExpectedHeader()
    {
        (new AcceptCharsetFactory)->make(
            new Str('foo'),
            new Str('')
        );
    }
}
