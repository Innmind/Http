<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\{
    Accept\Charset,
    Parameter\Quality,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class AcceptCharsetValueTest extends TestCase
{
    public function testInterface()
    {
        $a = Charset::maybe('unicode-1-1', $q = Quality::of(80))->match(
            static fn($charset) => $charset,
            static fn() => null,
        );

        $this->assertInstanceOf(Charset::class, $a);
        $this->assertSame($q, $a->quality());
        $this->assertSame('unicode-1-1;q=0.8', $a->toString());

        Charset::maybe('iso-8859-5', Quality::max())->match(
            static fn($charset) => $charset,
            static fn() => throw new \Exception,
        );
        Charset::maybe('Shift_JIS', Quality::max())->match(
            static fn($charset) => $charset,
            static fn() => throw new \Exception,
        );
        Charset::maybe('ISO_8859-9:1989', Quality::max())->match(
            static fn($charset) => $charset,
            static fn() => throw new \Exception,
        );
        Charset::maybe('NF_Z_62-010_(1973)', Quality::max())->match(
            static fn($charset) => $charset,
            static fn() => throw new \Exception,
        );
        Charset::maybe('*', Quality::max())->match(
            static fn($charset) => $charset,
            static fn() => throw new \Exception,
        );
    }

    public function testDefaultQuality()
    {
        $this->assertSame(
            '1',
            Charset::maybe('*')
                ->match(
                    static fn($charset) => $charset,
                    static fn() => null,
                )
                ?->quality()
                ?->toParameter()
                ?->value(),
        );
    }

    #[DataProvider('invalids')]
    public function testReturnNothingWhenInvalidAcceptCharsetValue($value)
    {
        $this->assertNull(Charset::maybe($value, Quality::max())->match(
            static fn($charset) => $charset,
            static fn() => null,
        ));
    }

    public static function invalids(): array
    {
        return [
            ['@'],
            ['bar+suffix'],
            ['foo/bar;q=0.8, level=1'],
        ];
    }
}
