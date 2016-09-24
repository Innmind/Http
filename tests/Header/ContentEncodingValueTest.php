<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\{
    ContentEncodingValue,
    HeaderValueInterface
};

class ContentEncodingValueTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $a = new ContentEncodingValue('compress');

        $this->assertInstanceOf(HeaderValueInterface::class, $a);
        $this->assertSame('compress', (string) $a);

        new ContentEncodingValue('identity');
        new ContentEncodingValue('x-compress');
    }

    /**
     * @dataProvider invalids
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenInvalidContentEncodingValue($value)
    {
        new ContentEncodingValue($value);
    }

    public function invalids(): array
    {
        return [
            ['*'],
            ['@'],
            ['bar+suffix'],
            ['foo/bar'],
        ];
    }
}
