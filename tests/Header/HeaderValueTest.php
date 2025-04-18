<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\Value;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class HeaderValueTest extends TestCase
{
    public function testInterface()
    {
        $hv = new Value\Value('foo');

        $this->assertInstanceOf(Value::class, $hv);
        $this->assertSame('foo', $hv->toString());
    }
}
