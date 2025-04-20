<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\ContentRange,
    Header,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class ContentRangeTest extends TestCase
{
    public function testOf()
    {
        $header = ContentRange::of('bytes', 0, 42);

        $this->assertInstanceOf(ContentRange::class, $header);
        $this->assertInstanceOf(Header\Custom::class, $header);
        $this->assertSame('Content-Range: bytes 0-42/*', $header->normalize()->toString());
    }

    public function testValids()
    {
        $this->assertSame(
            'Content-Range: resources 0-42/*',
            ContentRange::of('resources', 0, 42)->normalize()->toString(),
        );
        $this->assertSame(
            'Content-Range: resources 0-499/1234',
            ContentRange::of('resources', 0, 499, 1234)->normalize()->toString(),
        );
    }

    #[DataProvider('invalids')]
    public function testReturnNothingWhenInvalidContentRangeValue($unit, $first, $last, $length)
    {
        $this->assertNull(ContentRange::maybe($unit, $first, $last, $length)->match(
            static fn($header) => $header,
            static fn() => null,
        ));
    }

    public static function invalids()
    {
        return [
            ['', 0, 42, null],
            ['foo', -1, 42, null],
            ['foo', 0, -42, null],
            ['foo', 0, 42, -42],
            ['foo', 100, 42, 142],
            ['foo', 100, 142, 42],
        ];
    }
}
