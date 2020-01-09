<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Message;

use Innmind\Http\Message\{
    Query,
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

        $this->assertTrue($f->contains('foo'));
        $this->assertFalse($f->contains('bar'));
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
        $this->assertTrue($query->contains('foo'));
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
