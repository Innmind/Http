<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\{
    Accept\Language,
    Parameter\Quality,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class AcceptLanguageValueTest extends TestCase
{
    public function testInterface()
    {
        $a = Language::maybe('en-gb', $q = Quality::of(80))->match(
            static fn($language) => $language,
            static fn() => null,
        );

        $this->assertInstanceOf(Language::class, $a);
        $this->assertSame($q, $a->quality());
        $this->assertSame('en-gb;q=0.8', $a->toString());

        $_ = Language::maybe('fr', Quality::max())->match(
            static fn($language) => $language,
            static fn() => throw new \Exception,
        );
        $_ = Language::maybe('fr-FR', Quality::max())->match(
            static fn($language) => $language,
            static fn() => throw new \Exception,
        );
        $_ = Language::maybe('sgn-CH-DE', Quality::max())->match(
            static fn($language) => $language,
            static fn() => throw new \Exception,
        );
        $_ = Language::maybe('*', Quality::max())->match(
            static fn($language) => $language,
            static fn() => throw new \Exception,
        );
    }

    public function testDefaultQuality()
    {
        $this->assertSame(
            '1',
            Language::maybe('fr')
                ->match(
                    static fn($quality) => $quality,
                    static fn() => null,
                )
                ?->quality()
                ?->toParameter()
                ?->value(),
        );
    }

    #[DataProvider('invalids')]
    public function testReturnNothingWhenInvalidAcceptLanguageValue($value)
    {
        $this->assertNull(Language::maybe($value, Quality::max())->match(
            static fn($language) => $language,
            static fn() => null,
        ));
    }

    public static function invalids(): array
    {
        return [
            ['@'],
            ['*;level=1'],
            ['foo/bar'],
        ];
    }
}
