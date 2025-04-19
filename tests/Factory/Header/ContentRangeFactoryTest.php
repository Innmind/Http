<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\ContentRangeFactory,
    Header\ContentRange,
};
use Innmind\Immutable\Str;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class ContentRangeFactoryTest extends TestCase
{
    public function testMakeWithoutLength()
    {
        $header = (new ContentRangeFactory)(
            Str::of('Content-Range'),
            Str::of('bytes 0-42/*'),
        )->match(
            static fn($header) => $header,
            static fn() => null,
        );

        $this->assertInstanceOf(ContentRange::class, $header);
        $this->assertSame('Content-Range: bytes 0-42/*', $header->toString());
    }

    public function testMakeWithLength()
    {
        $header = (new ContentRangeFactory)(
            Str::of('Content-Range'),
            Str::of('bytes 0-42/66'),
        )->match(
            static fn($header) => $header,
            static fn() => null,
        );

        $this->assertInstanceOf(ContentRange::class, $header);
        $this->assertSame('Content-Range: bytes 0-42/66', $header->toString());
    }

    public function testReturnNothingWhenNotExpectedHeader()
    {
        $this->assertNull((new ContentRangeFactory)(
            Str::of('foo'),
            Str::of(''),
        )->match(
            static fn($header) => $header,
            static fn() => null,
        ));
    }

    public function testReturnNothingWhenNotValid()
    {
        $this->assertNull((new ContentRangeFactory)(
            Str::of('Content-Range'),
            Str::of('foo'),
        )->match(
            static fn($header) => $header,
            static fn() => null,
        ));
    }
}
