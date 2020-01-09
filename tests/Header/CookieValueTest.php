<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\{
    CookieValue,
    Value,
    Parameter
};
use Innmind\Immutable\MapInterface;
use PHPUnit\Framework\TestCase;

class CookieValueTest extends TestCase
{
    public function testInterface()
    {
        $cookie = new CookieValue(
            new Parameter\Parameter('foo', 'bar'),
            new Parameter\Parameter('bar', 'baz')
        );

        $this->assertInstanceOf(Value::class, $cookie);
        $this->assertInstanceOf(MapInterface::class, $cookie->parameters());
        $this->assertSame('string', (string) $cookie->parameters()->keyType());
        $this->assertSame(Parameter::class, (string) $cookie->parameters()->valueType());
        $this->assertCount(2, $cookie->parameters());
        $this->assertSame('bar', $cookie->parameters()->get('foo')->value());
        $this->assertSame('baz', $cookie->parameters()->get('bar')->value());
        $this->assertSame('foo=bar; bar=baz', $cookie->toString());
    }
}
