<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Header;

use Innmind\Http\Header\{
    AcceptLanguageValue,
    HeaderValueInterface,
    Quality
};

class AcceptLanguageValueTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $a = new AcceptLanguageValue('en-gb;q=0.8');

        $this->assertInstanceOf(HeaderValueInterface::class, $a);
        $this->assertSame('en-gb;q=0.8', (string) $a);

        new AcceptLanguageValue('fr');
        new AcceptLanguageValue('fr-FR');
        new AcceptLanguageValue('sgn-CH-DE');
        new AcceptLanguageValue('*');
    }

    public function testQuality()
    {
        $p = (new AcceptLanguageValue('en-gb;q=0.8'))->quality();
        $this->assertInstanceOf(Quality::class, $p);
        $this->assertSame('0.8', $p->value());
        $this->assertSame('1', (new AcceptLanguageValue('fr'))->quality()->value());
    }

    /**
     * @dataProvider invalids
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenInvalidAcceptLanguageValue($value)
    {
        new AcceptLanguageValue($value);
    }

    public function invalids(): array
    {
        return [
            ['@'],
            ['*;level=1;q=0.8'],
            ['foo/bar'],
        ];
    }
}
