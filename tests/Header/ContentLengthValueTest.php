<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\{
    ContentLengthValue,
    Value
};
use PHPUnit\Framework\TestCase;

class ContentLengthValueTest extends TestCase
{
    public function testInterface()
    {
        $a = new ContentLengthValue(42);

        $this->assertInstanceOf(Value::class, $a);
        $this->assertSame('42', $a->toString());

        new ContentLengthValue(0);
    }

    /**
     * @expectedException Innmind\Http\Exception\DomainException
     */
    public function testThrowWhenInvalidContentLengthValue()
    {
        new ContentLengthValue(-1);
    }
}
