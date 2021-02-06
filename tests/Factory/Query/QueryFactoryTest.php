<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Query;

use Innmind\Http\{
    Factory\Query\QueryFactory,
    Factory\QueryFactory as QueryFactoryInterface,
    Message\Query
};
use PHPUnit\Framework\TestCase;

class QueryFactoryTest extends TestCase
{
    public function testMake()
    {
        $f = new QueryFactory;

        $this->assertInstanceOf(QueryFactoryInterface::class, $f);

        $_GET = [
            'foo' => 'bar',
            'baz' => 'foo',
        ];
        $q = ($f)();

        $this->assertInstanceOf(Query::class, $q);
        $this->assertSame(2, $q->count());
        $this->assertSame('bar', $q->get('foo')->value());
        $this->assertSame('foo', $q->get('baz')->value());
    }
}
