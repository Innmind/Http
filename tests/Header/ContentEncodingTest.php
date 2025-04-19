<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\ContentEncoding,
    Header,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class ContentEncodingTest extends TestCase
{
    public function testOf()
    {
        $header = ContentEncoding::of('compress');

        $this->assertInstanceOf(ContentEncoding::class, $header);
        $this->assertInstanceOf(Header\Provider::class, $header);
        $this->assertSame('Content-Encoding: compress', $header->toHeader()->toString());
    }

    public function testValids()
    {
        $this->assertInstanceOf(
            ContentEncoding::class,
            ContentEncoding::of('compress'),
        );
        $this->assertInstanceOf(
            ContentEncoding::class,
            ContentEncoding::of('x-compress'),
        );
        $this->assertInstanceOf(
            ContentEncoding::class,
            ContentEncoding::of('identity'),
        );
    }

    #[DataProvider('invalids')]
    public function testReturnNothingWhenInvalidContentEncodingValue($value)
    {
        $this->assertNull(ContentEncoding::maybe($value)->match(
            static fn($header) => $header,
            static fn() => null,
        ));
    }

    public static function invalids(): array
    {
        return [
            ['*'],
            ['@'],
            ['bar+suffix'],
            ['foo/bar'],
        ];
    }
}
