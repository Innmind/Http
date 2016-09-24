<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactoryInterface,
    Factory\Header\ContentEncodingFactory,
    Header\ContentEncoding
};
use Innmind\Immutable\StringPrimitive as Str;

class ContentEncodingFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            HeaderFactoryInterface::class,
            new ContentEncodingFactory
        );
    }

    public function testMake()
    {
        $header = (new ContentEncodingFactory)->make(
            new Str('Content-Encoding'),
            new Str('x-gzip')
        );

        $this->assertInstanceOf(ContentEncoding::class, $header);
        $this->assertSame('Content-Encoding : x-gzip', (string) $header);
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenNotExpectedHeader()
    {
        (new ContentEncodingFactory)->make(
            new Str('foo'),
            new Str('')
        );
    }
}
