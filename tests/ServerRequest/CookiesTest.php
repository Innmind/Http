<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\ServerRequest;

use Innmind\Http\ServerRequest\Cookies;
use Innmind\Immutable\{
    Map,
    SideEffect,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class CookiesTest extends TestCase
{
    public function testInterface()
    {
        $f = Cookies::of(Map::of(['foo', '42']));

        $this->assertTrue($f->contains('foo'));
        $this->assertFalse($f->contains('bar'));
        $this->assertSame('42', $f->get('foo')->match(
            static fn($foo) => $foo,
            static fn() => null,
        ));
        $this->assertSame(1, $f->count());
    }

    public function testReturnNothingWhenAccessingUnknownCookie()
    {
        $this->assertNull(Cookies::of()->get('foo')->match(
            static fn($foo) => $foo,
            static fn() => null,
        ));
    }

    public function testForeach()
    {
        $cookies = Cookies::of(
            Map::of()
                ('foo', '42')
                ('bar', 'baz'),
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
        $cookies = Cookies::of(
            Map::of()
                ('foo', '42')
                ('bar', 'baz'),
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
