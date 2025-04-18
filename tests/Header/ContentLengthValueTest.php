<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\ContentLengthValue,
    Header\Value,
    Exception\DomainException,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class ContentLengthValueTest extends TestCase
{
    public function testInterface()
    {
        $a = new ContentLengthValue(42);

        $this->assertInstanceOf(Value::class, $a);
        $this->assertSame('42', $a->toString());

        new ContentLengthValue(0);
    }

    public function testThrowWhenInvalidContentLengthValue()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('-1');

        new ContentLengthValue(-1);
    }
}
