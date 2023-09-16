<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\AcceptRangesValue,
    Header\Value,
    Header\Parameter\Quality,
    Exception\DomainException,
};
use PHPUnit\Framework\TestCase;

class AcceptRangesValueTest extends TestCase
{
    public function testInterface()
    {
        $a = new AcceptRangesValue('bytes');

        $this->assertInstanceOf(Value::class, $a);
        $this->assertSame('bytes', $a->toString());

        new AcceptRangesValue('none');
        new AcceptRangesValue('whatever');
    }

    /**
     * @dataProvider invalids
     */
    public function testThrowWhenInvalidAcceptRangeValue($value)
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage($value);

        new AcceptRangesValue($value);
    }

    public static function invalids(): array
    {
        return [
            ['*'],
            ['foo/bar'],
            ['bar;q=0.8'],
        ];
    }
}
