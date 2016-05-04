<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Header;

use Innmind\Http\Header\{
    AcceptRangesValue,
    HeaderValueInterface,
    Quality
};

class AcceptRangesValueTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $a = new AcceptRangesValue('bytes');

        $this->assertInstanceOf(HeaderValueInterface::class, $a);
        $this->assertSame('bytes', (string) $a);

        new AcceptRangesValue('none');
        new AcceptRangesValue('whatever');
    }

    /**
     * @dataProvider invalids
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenInvalidAcceptRangeValue($value)
    {
        new AcceptRangesValue($value);
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
