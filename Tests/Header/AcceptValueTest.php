<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Header;

use Innmind\Http\Header\{
    AcceptValue,
    HeaderValueInterface,
    Quality
};

class AcceptValueTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $a = new AcceptValue('text/x-c; q=0.8');

        $this->assertInstanceOf(HeaderValueInterface::class, $a);
        $this->assertSame('text/x-c; q=0.8', (string) $a);

        new AcceptValue('text/html;level=1');
        new AcceptValue('text/html;level=1;q=0.4');
        new AcceptValue('text/html');
        new AcceptValue('text/*');
        new AcceptValue('*/*');
    }

    public function testQuality()
    {
        $p = (new AcceptValue('text/html;q=0.8'))->quality();
        $this->assertInstanceOf(Quality::class, $p);
        $this->assertSame('0.8', $p->value());
        $this->assertSame('1', (new AcceptValue('*/*'))->quality()->value());
    }

    /**
     * @dataProvider invalids
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenInvalidAcceptValue($value)
    {
        new AcceptValue($value);
    }

    public function invalids(): array
    {
        return [
            ['foo'],
            ['foo/bar+suffix'],
            ['foo/bar;q=0.8, level=1'],
        ];
    }
}
