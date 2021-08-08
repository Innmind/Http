<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Message;

use Innmind\Http\{
    Message\Cookies,
    Exception\CookieNotFound,
};
use Innmind\Immutable\{
    Map,
    SideEffect,
};
use PHPUnit\Framework\TestCase;

class CookiesTest extends TestCase
{
    public function testInterface()
    {
        $f = new Cookies(Map::of(['foo', '42']));

        $this->assertTrue($f->contains('foo'));
        $this->assertFalse($f->contains('bar'));
        $this->assertSame('42', $f->get('foo'));
        $this->assertSame(1, $f->count());
    }

    public function testThrowWhenAccessingUnknownCookie()
    {
        $this->expectException(CookieNotFound::class);
        $this->expectExceptionMessage('foo');

        (new Cookies)->get('foo');
    }

    public function testForeach()
    {
        $cookies = new Cookies(
            Map::of()
                ('foo', '42')
                ('bar', 'baz')
        );

        $called = 0;
        $this->assertInstanceOf(
            SideEffect::class,
            $cookies->foreach(static function() use (&$called) {
                ++$called;
            }),
        );
        $this->assertSame(2, $called);
    }

    public function testReduce()
    {
        $cookies = new Cookies(
            Map::of()
                ('foo', '42')
                ('bar', 'baz')
        );

        $reduced = $cookies->reduce(
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
