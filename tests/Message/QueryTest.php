<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Message;

use Innmind\Http\{
    Message\Query,
    Message\Query\Parameter,
};
use Innmind\Immutable\SideEffect;
use PHPUnit\Framework\TestCase;

class QueryTest extends TestCase
{
    public function testInterface()
    {
        $f = new Query(
            $p = new Parameter(
                'foo',
                '24',
            ),
        );

        $this->assertTrue($f->contains('foo'));
        $this->assertFalse($f->contains('bar'));
        $this->assertSame($p, $f->get('foo')->match(
            static fn($foo) => $foo,
            static fn() => null,
        ));
        $this->assertSame(1, $f->count());
    }

    public function testOf()
    {
        $query = Query::of(new Parameter('foo', '24'));

        $this->assertInstanceOf(Query::class, $query);
        $this->assertTrue($query->contains('foo'));
    }

    public function testReturnNothingWhenAccessingUnknownParameter()
    {
        $this->assertNull((new Query)->get('foo')->match(
            static fn($foo) => $foo,
            static fn() => null,
        ));
    }

    public function testForeach()
    {
        $query = new Query(
            new Parameter('foo', 'bar'),
            new Parameter('bar', 'baz'),
        );

        $called = 0;
        $this->assertInstanceOf(
            SideEffect::class,
            $query->foreach(static function() use (&$called) {
                ++$called;
            }),
        );
        $this->assertSame(2, $called);
    }

    public function testReduce()
    {
        $query = new Query(
            new Parameter('foo', 'bar'),
            new Parameter('bar', 'baz'),
        );

        $reduced = $query->reduce(
            [],
            static function($carry, $parameter) {
                $carry[] = $parameter->name();
                $carry[] = $parameter->value();

                return $carry;
            },
        );

        $this->assertSame(['foo', 'bar', 'bar', 'baz'], $reduced);
    }
}
