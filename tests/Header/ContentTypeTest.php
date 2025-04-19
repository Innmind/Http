<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\ContentType,
    Header,
};
use Innmind\MediaType\MediaType;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class ContentTypeTest extends TestCase
{
    public function testInterface()
    {
        $h = ContentType::of(
            $ct = MediaType::of('text/html; charset="UTF-8"'),
        );

        $this->assertInstanceOf(Header\Provider::class, $h);
        $this->assertSame('Content-Type: text/html;charset=UTF-8', $h->toHeader()->toString());
        $this->assertSame('text/html; charset=UTF-8', $h->content()->toString());
    }

    #[DataProvider('invalids')]
    public function testReturnNothingWhenInvalidContentTypeValue($type, $sub)
    {
        $this->assertNull(
            MediaType::maybe("$type/$sub")
                ->map(ContentType::of(...))
                ->match(
                    static fn($header) => $header,
                    static fn() => null,
                ),
        );
    }

    public static function invalids(): array
    {
        return [
            ['*', '*'],
            ['*', 'octet-stream'],
            ['text', '*'],
            ['foo/bar', ''],
            ['foo', 'bar+suffix'],
            ['foo', 'bar, level=1'],
        ];
    }
}
