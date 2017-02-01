<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactoryInterface,
    Factory\Header\ContentRangeFactory,
    Header\ContentRange
};
use Innmind\Immutable\StringPrimitive as Str;

class ContentRangeFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            HeaderFactoryInterface::class,
            new ContentRangeFactory
        );
    }

    public function testMakeWithoutLength()
    {
        $header = (new ContentRangeFactory)->make(
            new Str('Content-Range'),
            new Str('bytes 0-42/*')
        );

        $this->assertInstanceOf(ContentRange::class, $header);
        $this->assertSame('Content-Range : bytes 0-42/*', (string) $header);
    }

    public function testMakeWithLength()
    {
        $header = (new ContentRangeFactory)->make(
            new Str('Content-Range'),
            new Str('bytes 0-42/66')
        );

        $this->assertInstanceOf(ContentRange::class, $header);
        $this->assertSame('Content-Range : bytes 0-42/66', (string) $header);
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenNotExpectedHeader()
    {
        (new ContentRangeFactory)->make(
            new Str('foo'),
            new Str('')
        );
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenNotValid()
    {
        (new ContentRangeFactory)->make(
            new Str('Content-Range'),
            new Str('foo')
        );
    }
}
