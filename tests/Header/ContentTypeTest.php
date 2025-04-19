<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\ContentType,
    Header,
};
use Innmind\MediaType\MediaType;
use Innmind\Immutable\Sequence;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class ContentTypeTest extends TestCase
{
    public function testInterface()
    {
        $h = ContentType::of(
            $ct = MediaType::of('text/html; charset="UTF-8"'),
        );

        $this->assertInstanceOf(Header::class, $h);
        $this->assertSame('Content-Type', $h->name());
        $v = $h->values();
        $this->assertInstanceOf(Sequence::class, $v);
        $this->assertSame($ct, $h->content());
        $this->assertSame('Content-Type: text/html;charset=UTF-8', $h->toString());
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
