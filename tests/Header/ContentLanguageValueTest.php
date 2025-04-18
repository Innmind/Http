<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\ContentLanguageValue,
    Header\Value,
    Exception\DomainException,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class ContentLanguageValueTest extends TestCase
{
    public function testInterface()
    {
        $a = new ContentLanguageValue('en-gb');

        $this->assertInstanceOf(Value::class, $a);
        $this->assertSame('en-gb', $a->toString());

        new ContentLanguageValue('fr');
        new ContentLanguageValue('fr-FR');
        new ContentLanguageValue('sgn-CH-DE');
    }

    #[DataProvider('invalids')]
    public function testThrowWhenInvalidContentLanguageValue($value)
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage($value);

        new ContentLanguageValue($value);
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
