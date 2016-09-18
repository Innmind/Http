<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Message;

use Innmind\Http\Message\{
    Query,
    QueryInterface,
    Query\Parameter,
    Query\ParameterInterface
};
use Innmind\Immutable\Map;

class QueryTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $f = new Query(
            (new Map('string', ParameterInterface::class))
                ->put(
                    'foo',
                    $p = new Parameter(
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

    /**
     * @expectedException Innmind\Http\Exception\QueryParameterNotFoundException
     */
    public function testThrowWhenAccessingUnknownParameter()
    {
        (new Query(
            new Map('string', ParameterInterface::class)
        ))
            ->get('foo');
    }

    /**
     * @expectedException Innmind\Http\Exception\InvalidArgumentException
     */
    public function testThrowWhenInvalidMap()
    {
        new Query(new Map('string', 'string'));
    }
}
