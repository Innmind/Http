<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Header;

use Innmind\Http\Header\{
    CookieValue,
    Value,
    Parameter
};
use Innmind\Immutable\Map;
use PHPUnit\Framework\TestCase;

class CookieValueTest extends TestCase
{
    public function testInterface()
    {
        $cookie = new CookieValue(
            new Parameter\Parameter('foo', 'bar'),
            new Parameter\Parameter('bar', 'baz'),
        );

        $this->assertInstanceOf(Value::class, $cookie);
        $this->assertInstanceOf(Map::class, $cookie->parameters());
        $this->assertCount(2, $cookie->parameters());
        $this->assertSame('bar', $cookie->parameters()->get('foo')->match(
            static fn($foo) => $foo->value(),
            static fn() => null,
        ));
        $this->assertSame('baz', $cookie->parameters()->get('bar')->match(
            static fn($bar) => $bar->value(),
            static fn() => null,
        ));
        $this->assertSame('foo=bar; bar=baz', $cookie->toString());
    }
}
