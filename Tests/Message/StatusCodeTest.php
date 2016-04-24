<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Message;

use Innmind\Http\Message\{
    StatusCode,
    StatusCodeInterface
};
use Innmind\Immutable\MapInterface;

class StatusCodeTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $c = new StatusCode(200);

        $this->assertInstanceOf(StatusCodeInterface::class, $c);
        $this->assertSame(200, $c->value());
        $this->assertSame('200', (string) $c);
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenInvalidStatusCode()
    {
        new StatusCode(42); //sadly
    }

    public function testCodes()
    {
        $codes = StatusCode::codes();

        $this->assertInstanceOf(MapInterface::class, $codes);
        $this->assertSame('string', (string) $codes->keyType());
        $this->assertSame('int', (string) $codes->valueType());
        $this->assertSame(61, $codes->count());
    }
}
