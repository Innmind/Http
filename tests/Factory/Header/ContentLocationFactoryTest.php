<?php
declare(strict_types = 1);

namespace Test\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\HeaderFactory,
    Factory\Header\ContentLocationFactory,
    Header\ContentLocation,
};
use Innmind\Immutable\Str;
use PHPUnit\Framework\TestCase;

class ContentLocationFactoryTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            HeaderFactory::class,
            new ContentLocationFactory,
        );
    }

    public function testMake()
    {
        $header = (new ContentLocationFactory)(
            Str::of('Content-Location'),
            Str::of('http://example.com'),
        )->match(
            static fn($header) => $header,
            static fn() => null,
        );

        $this->assertInstanceOf(ContentLocation::class, $header);
        $this->assertSame('Content-Location: http://example.com/', $header->toString());
    }

    public function testReturnNothingWhenNotExpectedHeader()
    {
        $this->assertNull((new ContentLocationFactory)(
            Str::of('foo'),
            Str::of(''),
        )->match(
            static fn($header) => $header,
            static fn() => null,
        ));
    }
}
