<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Header;

use Innmind\Http\Header\{
    AcceptEncodingValue,
    HeaderValueInterface,
    Quality
};

class AcceptEncodingValueTest extends \PHPUnit_Framework_TestCase
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
