<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\ContentLengthFactory,
    Header\ContentLength,
};
use Innmind\Immutable\Str;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class ContentLengthFactoryTest extends TestCase
{
    public function testMake()
    {
        $header = (new ContentLengthFactory)(
            Str::of('Content-Length'),
            Str::of('42'),
        )->match(
            static fn($header) => $header,
            static fn() => null,
        );

        $this->assertInstanceOf(ContentLength::class, $header);
        $this->assertSame('Content-Length: 42', $header->toString());
    }

    public function testReturnNothingWhenNotExpectedHeader()
    {
        $this->assertNull((new ContentLengthFactory)(
            Str::of('foo'),
            Str::of(''),
        )->match(
            static fn($header) => $header,
            static fn() => null,
        ));
    }
}
