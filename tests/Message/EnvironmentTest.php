<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Message;

use Innmind\Http\Message\{
    Environment,
};
use Innmind\Immutable\Map;
use PHPUnit\Framework\TestCase;

class EnvironmentTest extends TestCase
{
    public function testInterface()
    {
        $f = new Environment(
            Map::of('string', 'scalar')
                ->put('foo', 42)
        );

        $this->assertTrue($f->contains('foo'));
        $this->assertFalse($f->contains('bar'));
        $this->assertSame(42, $f->get('foo'));
        $this->assertSame(1, $f->count());
    }

    /**
     * @expectedException Innmind\Http\Exception\EnvironmentVariableNotFound
     */
    public function testThrowWhenAccessingUnknownVariable()
    {
        (new Environment)->get('foo');
    }

    /**
     * @expectedException TypeError
     * @expectedExceptionMessage Argument 1 must be of type Map<string, scalar>
     */
    public function testThrowWhenInvalidMap()
    {
        new Environment(Map::of('string', 'string'));
    }

    public function testForeach()
    {
        $variables = new Environment(
            Map::of('string', 'scalar')
                ('foo', 42)
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
            Map::of('string', 'scalar')
                ('foo', 42)
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

        $this->assertSame(['foo', 42, 'bar', 'baz'], $reduced);
    }
}
