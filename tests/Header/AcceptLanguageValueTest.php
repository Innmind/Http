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
        $a = Language::maybe('en-gb', $q = new Quality(0.8))->match(
            static fn($language) => $language,
            static fn() => null,
        );

        $this->assertInstanceOf(Language::class, $a);
        $this->assertSame($q, $a->quality());
        $this->assertSame('en-gb;q=0.8', $a->toString());

        Language::maybe('fr', new Quality(1))->match(
            static fn($language) => $language,
            static fn() => throw new \Exception,
        );
        Language::maybe('fr-FR', new Quality(1))->match(
            static fn($language) => $language,
            static fn() => throw new \Exception,
        );
        Language::maybe('sgn-CH-DE', new Quality(1))->match(
            static fn($language) => $language,
            static fn() => throw new \Exception,
        );
        Language::maybe('*', new Quality(1))->match(
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
                ?->value(),
        );
    }

    #[DataProvider('invalids')]
    public function testReturnNothingWhenInvalidAcceptLanguageValue($value)
    {
        $this->assertNull(Language::maybe($value, new Quality(1))->match(
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
