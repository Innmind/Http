<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Header;

use Innmind\Http\Header\{
    AcceptEncodingValue,
    HeaderValueInterface
};

class AcceptEncodingValueTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $a = new AcceptEncodingValue('compress');

        $this->assertInstanceOf(HeaderValueInterface::class, $a);
        $this->assertSame('compress', (string) $a);

        new AcceptEncodingValue('*');
        new AcceptEncodingValue('compress;q=0.5');
        new AcceptEncodingValue('identity; q=0.5');
        new AcceptEncodingValue('*;q=0');
    }

    /**
     * @dataProvider invalids
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenInvalidAcceptEncodingValue($value)
    {
        new AcceptEncodingValue($value);
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
