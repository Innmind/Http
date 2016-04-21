<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Header;

use Innmind\Http\Header\{
    AcceptRangeValue,
    HeaderValueInterface,
    Quality
};

class AcceptRangeValueTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $a = new AcceptRangeValue('bytes');

        $this->assertInstanceOf(HeaderValueInterface::class, $a);
        $this->assertSame('bytes', (string) $a);

        new AcceptRangeValue('none');
        new AcceptRangeValue('whatever');
    }

    /**
     * @dataProvider invalids
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenInvalidAcceptRangeValue($value)
    {
        new AcceptRangeValue($value);
    }

    public function invalids(): array
    {
        return [
            ['*'],
            ['foo/bar'],
            ['bar;q=0.8'],
        ];
    }
}
