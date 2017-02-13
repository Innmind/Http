<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\{
    AcceptLanguageValue,
    HeaderValueInterface,
    Quality
};
use PHPUnit\Framework\TestCase;

class AcceptLanguageValueTest extends TestCase
{
    public function testInterface()
    {
        $a = new AcceptLanguageValue('en-gb', $q = new Quality(0.8));

        $this->assertInstanceOf(HeaderValueInterface::class, $a);
        $this->assertSame($q, $a->quality());
        $this->assertSame('en-gb;q=0.8', (string) $a);

        new AcceptLanguageValue('fr', new Quality(1));
        new AcceptLanguageValue('fr-FR', new Quality(1));
        new AcceptLanguageValue('sgn-CH-DE', new Quality(1));
        new AcceptLanguageValue('*', new Quality(1));
    }

    public function testDefaultQuality()
    {
        $this->assertSame(
            '1',
            (new AcceptLanguageValue('fr'))->quality()->value()
        );
    }

    /**
     * @dataProvider invalids
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenInvalidAcceptLanguageValue($value)
    {
        new AcceptLanguageValue($value, new Quality(1));
    }

    public function invalids(): array
    {
        return [
            ['@'],
            ['*;level=1'],
            ['foo/bar'],
        ];
    }
}
