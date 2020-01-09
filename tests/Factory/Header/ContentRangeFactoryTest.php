<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory,
    Factory\Header\ContentRangeFactory,
    Header\ContentRange
};
use Innmind\Immutable\Str;
use PHPUnit\Framework\TestCase;

class ContentRangeFactoryTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            HeaderFactory::class,
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
        $this->assertSame('Content-Range: bytes 0-42/*', $header->toString());
    }

    public function testMakeWithLength()
    {
        $header = (new ContentRangeFactory)->make(
            new Str('Content-Range'),
            new Str('bytes 0-42/66')
        );

        $this->assertInstanceOf(ContentRange::class, $header);
        $this->assertSame('Content-Range: bytes 0-42/66', $header->toString());
    }

    /**
     * @expectedException Innmind\Http\Exception\DomainException
     */
    public function testThrowWhenNotExpectedHeader()
    {
        (new ContentRangeFactory)->make(
            new Str('foo'),
            new Str('')
        );
    }

    /**
     * @expectedException Innmind\Http\Exception\DomainException
     */
    public function testThrowWhenNotValid()
    {
        (new ContentRangeFactory)->make(
            new Str('Content-Range'),
            new Str('foo')
        );
    }
}
