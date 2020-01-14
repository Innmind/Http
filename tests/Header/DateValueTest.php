<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\{
    DateValue,
    Value
};
use Innmind\TimeContinuum\Earth\PointInTime\PointInTime;
use PHPUnit\Framework\TestCase;

class DateValueTest extends TestCase
{
    public function testInterface()
    {
        $h = new DateValue(new PointInTime('2016-01-01 12:12:12+0200'));

        $this->assertInstanceOf(Value::class, $h);
        $this->assertSame('Fri, 01 Jan 2016 10:12:12 GMT', $h->toString());
    }
}
