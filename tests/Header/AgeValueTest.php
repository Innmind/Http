<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\AgeValue,
    Header\Value,
    Exception\DomainException,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class AgeValueTest extends TestCase
{
    public function testInterface()
    {
        $a = new AgeValue(42);

        $this->assertInstanceOf(Value::class, $a);
        $this->assertSame('42', $a->toString());

        new AgeValue(0);
    }

    public function testThrowWhenInvalidAgeValue()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('-1');

        new AgeValue(-1);
    }
}
