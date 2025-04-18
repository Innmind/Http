<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\{
    Header\WWWAuthenticateValue,
    Header\Value,
    Exception\DomainException
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class WWWAuthenticateValueTest extends TestCase
{
    public function testInterface()
    {
        $value = new WWWAuthenticateValue('Basic', 'some value');

        $this->assertInstanceOf(Value::class, $value);
        $this->assertSame('Basic', $value->scheme());
        $this->assertSame('some value', $value->realm());
        $this->assertSame('Basic realm="some value"', $value->toString());
    }

    public function testThrowWhenInvalidSchemeFormat()
    {
        $this->expectException(DomainException::class);

        new WWWAuthenticateValue('Foo bar', 'some value');
    }
}
