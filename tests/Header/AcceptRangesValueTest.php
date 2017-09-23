<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\{
    AcceptRangesValue,
    HeaderValue,
    Parameter\Quality
};
use PHPUnit\Framework\TestCase;

class AcceptRangesValueTest extends TestCase
{
    public function testInterface()
    {
        $a = new AcceptRangesValue('bytes');

        $this->assertInstanceOf(HeaderValue::class, $a);
        $this->assertSame('bytes', (string) $a);

        new AcceptRangesValue('none');
        new AcceptRangesValue('whatever');
    }

    /**
     * @dataProvider invalids
     * @expectedException Innmind\Http\Exception\DomainException
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
