<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\AcceptEncodingValue,
    Header\Value,
    Header\Parameter\Quality,
    Exception\DomainException,
};
use PHPUnit\Framework\TestCase;

class AcceptEncodingValueTest extends TestCase
{
    public function testInterface()
    {
        $a = new AcceptEncodingValue('compress', $q = new Quality(1));

        $this->assertInstanceOf(Value::class, $a);
        $this->assertSame($q, $a->quality());
        $this->assertSame('compress;q=1', $a->toString());

        new AcceptEncodingValue('*', new Quality(1));
        new AcceptEncodingValue('compress', new Quality(0.5));
        new AcceptEncodingValue('identity', new Quality(0.5));
        new AcceptEncodingValue('*', new Quality(0));
    }

    public function testDefaultQuality()
    {
        $this->assertSame(
            '1',
            (new AcceptEncodingValue('*'))->quality()->value(),
        );
    }

    /**
     * @dataProvider invalids
     */
    public function testThrowWhenInvalidAcceptEncodingValue($value)
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage($value);

        new AcceptEncodingValue($value, new Quality(1));
    }

    public static function invalids(): array
    {
        return [
            ['@'],
            ['bar+suffix'],
            ['foo/bar'],
        ];
    }
}
