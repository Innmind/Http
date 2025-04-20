<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\Accept\Encoding,
    Header\Parameter\Quality,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class AcceptEncodingValueTest extends TestCase
{
    public function testInterface()
    {
        $a = Encoding::maybe('compress', $q = new Quality(1))->match(
            static fn($encoding) => $encoding,
            static fn() => null,
        );

        $this->assertInstanceOf(Encoding::class, $a);
        $this->assertSame($q, $a->quality());
        $this->assertSame('compress;q=1', $a->toString());

        Encoding::maybe('*', new Quality(1))->match(
            static fn($encoding) => $encoding,
            static fn() => throw new \Exception,
        );
        Encoding::maybe('compress', new Quality(0.5))->match(
            static fn($encoding) => $encoding,
            static fn() => throw new \Exception,
        );
        Encoding::maybe('identity', new Quality(0.5))->match(
            static fn($encoding) => $encoding,
            static fn() => throw new \Exception,
        );
        Encoding::maybe('*', new Quality(0))->match(
            static fn($encoding) => $encoding,
            static fn() => throw new \Exception,
        );
    }

    public function testDefaultQuality()
    {
        $this->assertSame(
            '1',
            Encoding::maybe('*')
                ->match(
                    static fn($encoding) => $encoding,
                    static fn() => null,
                )
                ?->quality()
                ?->value(),
        );
    }

    #[DataProvider('invalids')]
    public function testReturnNothingWhenInvalidAcceptEncodingValue($value)
    {
        $this->assertNull(Encoding::maybe($value, new Quality(1))->match(
            static fn($encoding) => $encoding,
            static fn() => null,
        ));
    }

    public static function invalids(): array
    {
        return [
            ['@'],
            ['bar+suffix'],
            ['foo/bar'],
        ];
    }
}
