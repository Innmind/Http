<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\AcceptLanguageValue,
    Header\Value,
    Header\Parameter\Quality,
    Exception\DomainException,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class AcceptLanguageValueTest extends TestCase
{
    public function testInterface()
    {
        $a = new AcceptLanguageValue('en-gb', $q = new Quality(0.8));

        $this->assertInstanceOf(Value::class, $a);
        $this->assertSame($q, $a->quality());
        $this->assertSame('en-gb;q=0.8', $a->toString());

        new AcceptLanguageValue('fr', new Quality(1));
        new AcceptLanguageValue('fr-FR', new Quality(1));
        new AcceptLanguageValue('sgn-CH-DE', new Quality(1));
        new AcceptLanguageValue('*', new Quality(1));
    }

    public function testDefaultQuality()
    {
        $this->assertSame(
            '1',
            (new AcceptLanguageValue('fr'))->quality()->value(),
        );
    }

    #[DataProvider('invalids')]
    public function testThrowWhenInvalidAcceptLanguageValue($value)
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage($value);

        new AcceptLanguageValue($value, new Quality(1));
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
