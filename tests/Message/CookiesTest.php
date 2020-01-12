<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Message;

use Innmind\Http\Message\{
    Cookies,
};
use Innmind\Immutable\Map;
use PHPUnit\Framework\TestCase;

class CookiesTest extends TestCase
{
    public function testInterface()
    {
        $f = new Cookies(
            (new Map('string', 'scalar'))
                ->put('foo', 42)
        );

        $this->assertTrue($f->contains('foo'));
        $this->assertFalse($f->contains('bar'));
        $this->assertSame(42, $f->get('foo'));
        $this->assertSame(1, $f->count());
    }

    /**
     * @expectedException Innmind\Http\Exception\CookieNotFound
     */
    public function testThrowWhenAccessingUnknownCookie()
    {
        (new Cookies)->get('foo');
    }

    /**
     * @expectedException TypeError
     * @expectedExceptionMessage Argument 1 must be of type MapInterface<string, scalar>
     */
    public function testThrowWhenInvalidMap()
    {
        new Cookies(new Map('string', 'string'));
    }

    public function testForeach()
    {
        $cookies = new Cookies(
            Map::of('string', 'scalar')
                ('foo', 42)
                ('bar', 'baz')
        );

        $called = 0;
        $this->assertNull($cookies->foreach(function() use (&$called) {
            ++$called;
        }));
        $this->assertSame(2, $called);
    }

    public function testReduce()
    {
        $cookies = new Cookies(
            Map::of('string', 'scalar')
                ('foo', 42)
                ('bar', 'baz')
        );

        $reduced = $cookies->reduce(
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
