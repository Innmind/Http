<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\Content\Language;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class ContentLanguageValueTest extends TestCase
{
    public function testInterface()
    {
        $a = Language::maybe('en-gb')->match(
            static fn($language) => $language,
            static fn() => null,
        );

        $this->assertInstanceOf(Language::class, $a);
        $this->assertSame('en-gb', $a->toString());

        Language::maybe('fr')->match(
            static fn($language) => $language,
            static fn() => throw new \Exception,
        );
        Language::maybe('fr-FR')->match(
            static fn($language) => $language,
            static fn() => throw new \Exception,
        );
        Language::maybe('sgn-CH-DE')->match(
            static fn($language) => $language,
            static fn() => throw new \Exception,
        );
    }

    #[DataProvider('invalids')]
    public function testReturnNothingWhenInvalidContentLanguageValue($value)
    {
        $this->assertNull(Language::maybe($value)->match(
            static fn($language) => $language,
            static fn() => null,
        ));
    }

    public static function invalids(): array
    {
        return [
            ['*'],
            ['@'],
            ['*;level=1'],
            ['foo/bar'],
        ];
    }
}
