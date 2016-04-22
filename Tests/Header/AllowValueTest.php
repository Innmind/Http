<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Header;

use Innmind\Http\Header\{
    AllowValue,
    HeaderValueInterface,
    Quality
};

class AllowValueTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $a = new AllowValue('HEAD');

        $this->assertInstanceOf(HeaderValueInterface::class, $a);
        $this->assertSame('HEAD', (string) $a);

        new AllowValue('GET');
        new AllowValue('POST');
        new AllowValue('PUT');
        new AllowValue('DELETE');
        new AllowValue('TRACE');
        new AllowValue('CONNECT');
        new AllowValue('OPTIONS');
        new AllowValue('PATCH');
    }

    /**
     * @dataProvider invalids
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenInvalidAllowValue($value)
    {
        new AllowValue($value);
    }

    public function invalids(): array
    {
        return [
            ['42'],
            ['get'],
            ['FOO'],
        ];
    }
}
