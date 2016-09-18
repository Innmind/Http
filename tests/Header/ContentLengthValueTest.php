<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\{
    ContentLengthValue,
    HeaderValueInterface
};

class ContentLengthValueTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $a = new ContentLengthValue(42);

        $this->assertInstanceOf(HeaderValueInterface::class, $a);
        $this->assertSame('42', (string) $a);

        new ContentLengthValue(0);
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenInvalidContentLengthValue()
    {
        new ContentLengthValue(-1);
    }
}
