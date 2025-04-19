<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\AcceptRanges,
    Header,
};
use Innmind\Immutable\Sequence;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class AcceptRangesTest extends TestCase
{
    public function testOf()
    {
        $header = AcceptRanges::of('bytes');

        $this->assertInstanceOf(AcceptRanges::class, $header);
        $this->assertInstanceOf(Header::class, $header);
        $this->assertSame('Accept-Ranges', $header->name());
        $values = $header->values();
        $this->assertInstanceOf(Sequence::class, $values);
        $this->assertSame('Accept-Ranges: bytes', $header->toString());
    }

    public function testValid()
    {
        $this->assertInstanceOf(
            AcceptRanges::class,
            AcceptRanges::of('bytes'),
        );
        $this->assertInstanceOf(
            AcceptRanges::class,
            AcceptRanges::of('none'),
        );
        $this->assertInstanceOf(
            AcceptRanges::class,
            AcceptRanges::of('whatever'),
        );
    }

    #[DataProvider('invalids')]
    public function testReturnNothingWhenInvalidAcceptRangeValue($value)
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage($value);

        $this->assertNull(AcceptRanges::maybe($value)->match(
            static fn($header) => $header,
            static fn() => null,
        ));
    }

    public static function invalids(): array
    {
        return [
            ['*'],
            ['foo/bar'],
            ['bar;q=0.8'],
        ];
    }
}
