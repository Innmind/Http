<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\AcceptCharsetValue,
    Header\Value,
    Header\Parameter\Quality,
    Exception\DomainException,
};
use PHPUnit\Framework\TestCase;

class AcceptCharsetValueTest extends TestCase
{
    public function testInterface()
    {
        $a = new AcceptCharsetValue('unicode-1-1', $q = new Quality(0.8));

        $this->assertInstanceOf(Value::class, $a);
        $this->assertSame($q, $a->quality());
        $this->assertSame('unicode-1-1;q=0.8', $a->toString());

        new AcceptCharsetValue('iso-8859-5', new Quality(1));
        new AcceptCharsetValue('Shift_JIS', new Quality(1));
        new AcceptCharsetValue('ISO_8859-9:1989', new Quality(1));
        new AcceptCharsetValue('NF_Z_62-010_(1973)', new Quality(1));
        new AcceptCharsetValue('*', new Quality(1));
    }

    public function testDefaultQuality()
    {
        $this->assertSame(
            '1',
            (new AcceptCharsetValue('*'))->quality()->value(),
        );
    }

    /**
     * @dataProvider invalids
     */
    public function testThrowWhenInvalidAcceptCharsetValue($value)
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage($value);

        new AcceptCharsetValue($value, new Quality(1));
    }

    public static function invalids(): array
    {
        return [
            ['@'],
            ['bar+suffix'],
            ['foo/bar;q=0.8, level=1'],
        ];
    }
}
