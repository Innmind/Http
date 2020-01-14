<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Message;

use Innmind\Http\{
    Message\Environment,
    Exception\EnvironmentVariableNotFound,
};
use Innmind\Immutable\Map;
use PHPUnit\Framework\TestCase;

class EnvironmentTest extends TestCase
{
    public function testInterface()
    {
        $f = new Environment(
            Map::of('string', 'string')
                ('foo', '42')
        );

        $this->assertTrue($f->contains('foo'));
        $this->assertFalse($f->contains('bar'));
        $this->assertSame('42', $f->get('foo'));
        $this->assertSame(1, $f->count());
    }

    public function testThrowWhenAccessingUnknownVariable()
    {
        $this->expectException(EnvironmentVariableNotFound::class);
        $this->expectExceptionMessage('foo');

        (new Environment)->get('foo');
    }

    public function testThrowWhenInvalidMap()
    {
        $this->expectException(\TypeError::class);
        $this->expectExceptionMessage('Argument 1 must be of type Map<string, string>');

        new Environment(Map::of('string', 'scalar'));
    }

    public function testForeach()
    {
        $variables = new Environment(
            Map::of('string', 'string')
                ('foo', '42')
                ('bar', 'baz')
        );

        $called = 0;
        $this->assertNull($variables->foreach(function() use (&$called) {
            ++$called;
        }));
        $this->assertSame(2, $called);
    }

    public function testReduce()
    {
        $variables = new Environment(
            Map::of('string', 'string')
                ('foo', '42')
                ('bar', 'baz')
        );

        $reduced = $variables->reduce(
            [],
            function($carry, $name, $value) {
                $carry[] = $name;
                $carry[] = $value;

                return $carry;
            },
        );

        $this->assertSame(['foo', '42', 'bar', 'baz'], $reduced);
    }
}
