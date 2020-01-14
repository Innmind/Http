<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory,
    Factory\Header\ContentRangeFactory,
    Header\ContentRange,
    Exception\DomainException,
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
        $header = (new ContentRangeFactory)(
            Str::of('Content-Range'),
            Str::of('bytes 0-42/*'),
        );

        $this->assertInstanceOf(ContentRange::class, $header);
        $this->assertSame('Content-Range: bytes 0-42/*', $header->toString());
    }

    public function testMakeWithLength()
    {
        $header = (new ContentRangeFactory)(
            Str::of('Content-Range'),
            Str::of('bytes 0-42/66'),
        );

        $this->assertInstanceOf(ContentRange::class, $header);
        $this->assertSame('Content-Range: bytes 0-42/66', $header->toString());
    }

    public function testThrowWhenNotExpectedHeader()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('foo');

        (new ContentRangeFactory)(
            Str::of('foo'),
            Str::of(''),
        );
    }

    public function testThrowWhenNotValid()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Content-Range');

        (new ContentRangeFactory)(
            Str::of('Content-Range'),
            Str::of('foo'),
        );
    }
}
