<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\IfModifiedSinceFactory,
    Factory\HeaderFactoryInterface,
    Header\IfModifiedSince
};
use Innmind\Immutable\StringPrimitive as Str;

class IfModifiedSinceFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testMake()
    {
        $f = new IfModifiedSinceFactory;

        $this->assertInstanceOf(HeaderFactoryInterface::class, $f);

        $h = $f->make(
            new Str('If-Modified-Since'),
            new Str('Tue, 15 Nov 1994 08:12:31 GMT')
        );

        $this->assertInstanceOf(IfModifiedSince::class, $h);
        $this->assertSame(
            'If-Modified-Since : Tue, 15 Nov 1994 08:12:31 +0000',
            (string) $h
        );
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenNotExpectedHeader()
    {
        (new IfModifiedSinceFactory)->make(
            new Str('foo'),
            new Str('')
        );
    }
}
