<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Message\Query;

use Innmind\Http\Message\{
    Query\Query,
    Query as QueryInterface,
    Query\Parameter
};
use Innmind\Immutable\Map;
use PHPUnit\Framework\TestCase;

class QueryTest extends TestCase
{
    public function testInterface()
    {
        $f = new Query(
            (new Map('string', Parameter::class))
                ->put(
                    'foo',
                    $p = new Parameter\Parameter(
                        'foo',
                        24
                    )
                )
        );

        $this->assertInstanceOf(QueryInterface::class, $f);
        $this->assertTrue($f->has('foo'));
        $this->assertFalse($f->has('bar'));
        $this->assertSame($p, $f->get('foo'));
        $this->assertSame(1, $f->count());
        $this->assertSame($p, $f->current());
        $this->assertSame('foo', $f->key());
        $this->assertTrue($f->valid());
        $this->assertSame(null, $f->next());
        $this->assertFalse($f->valid());
        $this->assertSame(null, $f->rewind());
        $this->assertTrue($f->valid());
        $this->assertSame($p, $f->current());
    }

    public function testOf()
    {
        $query = Query::of(new Parameter\Parameter('foo', 24));

        $this->assertInstanceOf(Query::class, $query);
        $this->assertTrue($query->has('foo'));
    }

    /**
     * @expectedException Innmind\Http\Exception\QueryParameterNotFound
     */
    public function testThrowWhenAccessingUnknownParameter()
    {
        (new Query)->get('foo');
    }

    /**
     * @expectedException TypeError
     * @expectedExceptionMessage Argument 1 must be of type MapInterface<string, Innmind\Http\Message\Query\Parameter>
     */
    public function testThrowWhenInvalidMap()
    {
        new Query(new Map('string', 'string'));
    }
}
