<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\{
    AcceptEncodingValue,
    HeaderValueInterface,
    Quality
};
use PHPUnit\Framework\TestCase;

class AcceptEncodingValueTest extends TestCase
{
    public function testInterface()
    {
        $a = new AcceptEncodingValue('compress', $q = new Quality(1));

        $this->assertInstanceOf(HeaderValueInterface::class, $a);
        $this->assertSame($q, $a->quality());
        $this->assertSame('compress;q=1', (string) $a);

        new AcceptEncodingValue('*', new Quality(1));
        new AcceptEncodingValue('compress', new Quality(0.5));
        new AcceptEncodingValue('identity', new Quality(0.5));
        new AcceptEncodingValue('*', new Quality(0));
    }

    public function testDefaultQuality()
    {
        $this->assertSame(
            '1',
            (new AcceptEncodingValue('*'))->quality()->value()
        );
    }

    /**
     * @dataProvider invalids
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenInvalidAcceptEncodingValue($value)
    {
        new AcceptEncodingValue($value, new Quality(1));
    }

    public function invalids(): array
    {
        return [
            ['@'],
            ['bar+suffix'],
            ['foo/bar'],
        ];
    }
}
