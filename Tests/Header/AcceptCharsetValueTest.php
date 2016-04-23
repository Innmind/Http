<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Header;

use Innmind\Http\Header\{
    AcceptCharsetValue,
    HeaderValueInterface,
    Quality
};

class AcceptCharsetValueTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $a = new AcceptCharsetValue('unicode-1-1', $q = new Quality(0.8));

        $this->assertInstanceOf(HeaderValueInterface::class, $a);
        $this->assertSame($q, $a->quality());
        $this->assertSame('unicode-1-1;q=0.8', (string) $a);

        new AcceptCharsetValue('iso-8859-5', new Quality(1));
        new AcceptCharsetValue('Shift_JIS', new Quality(1));
        new AcceptCharsetValue('ISO_8859-9:1989', new Quality(1));
        new AcceptCharsetValue('NF_Z_62-010_(1973)', new Quality(1));
        new AcceptCharsetValue('*', new Quality(1));
    }

    /**
     * @dataProvider invalids
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenInvalidAcceptCharsetValue($value)
    {
        new AcceptCharsetValue($value, new Quality(1));
    }

    public function invalids(): array
    {
        return [
            ['@'],
            ['bar+suffix'],
            ['foo/bar;q=0.8, level=1'],
        ];
    }
}
