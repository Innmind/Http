<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Message;

use Innmind\Http\Message\Environment;
use Innmind\Immutable\{
    Map,
    SideEffect,
};
use PHPUnit\Framework\TestCase;

class EnvironmentTest extends TestCase
{
    public function testInterface()
    {
        $f = new Environment(Map::of(['foo', '42']));

        $this->assertTrue($f->contains('foo'));
        $this->assertFalse($f->contains('bar'));
        $this->assertSame('42', $f->get('foo')->match(
            static fn($foo) => $foo,
            static fn() => null,
        ));
        $this->assertSame(1, $f->count());
    }

    public function testReturnNothingWhenAccessingUnknownVariable()
    {
        $this->assertNull((new Environment)->get('foo')->match(
            static fn($foo) => $foo,
            static fn() => null,
        ));
    }

    public function testForeach()
    {
        $variables = new Environment(
            Map::of()
                ('foo', '42')
                ('bar', 'baz'),
        );

        $called = 0;
        $this->assertInstanceOf(
            SideEffect::class,
            $variables->foreach(static function() use (&$called) {
                ++$called;
            }),
        );
        $this->assertSame(2, $called);
    }

    public function testReduce()
    {
        $variables = new Environment(
            Map::of()
                ('foo', '42')
                ('bar', 'baz'),
        );

        $reduced = $variables->reduce(
            [],
            static function($carry, $name, $value) {
                $carry[] = $name;
                $carry[] = $value;

                return $carry;
            },
        );

        $this->assertSame(['foo', '42', 'bar', 'baz'], $reduced);
    }
}
