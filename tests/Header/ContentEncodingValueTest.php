<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\{
    ContentEncodingValue,
    Value
};
use PHPUnit\Framework\TestCase;

class ContentEncodingValueTest extends TestCase
{
    public function testInterface()
    {
        $a = new ContentEncodingValue('compress');

        $this->assertInstanceOf(Value::class, $a);
        $this->assertSame('compress', $a->toString());

        new ContentEncodingValue('identity');
        new ContentEncodingValue('x-compress');
    }

    /**
     * @dataProvider invalids
     * @expectedException Innmind\Http\Exception\DomainException
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
