<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\{
    ContentLanguageValue,
    Value
};
use PHPUnit\Framework\TestCase;

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

    /**
     * @dataProvider invalids
     * @expectedException Innmind\Http\Exception\DomainException
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
