<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\{
    ContentLanguageValue,
    HeaderValueInterface
};

class ContentLanguageValueTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $a = new ContentLanguageValue('en-gb');

        $this->assertInstanceOf(HeaderValueInterface::class, $a);
        $this->assertSame('en-gb', (string) $a);

        new ContentLanguageValue('fr');
        new ContentLanguageValue('fr-FR');
        new ContentLanguageValue('sgn-CH-DE');
    }

    /**
     * @dataProvider invalids
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenInvalidContentLanguageValue($value)
    {
        new ContentLanguageValue($value);
    }

    public function invalids(): array
    {
        return [
            ['*'],
            ['@'],
            ['*;level=1'],
            ['foo/bar'],
        ];
    }
}
