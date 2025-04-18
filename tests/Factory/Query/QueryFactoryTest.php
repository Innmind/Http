<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Query;

use Innmind\Http\{
    Factory\Query\QueryFactory,
    Factory\QueryFactory as QueryFactoryInterface,
    ServerRequest\Query,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class QueryFactoryTest extends TestCase
{
    public function testMake()
    {
        $_GET = [
            'foo' => 'bar',
            'baz' => 'foo',
        ];
        $f = QueryFactory::default();

        $this->assertInstanceOf(QueryFactoryInterface::class, $f);

        $q = ($f)();

        $this->assertInstanceOf(Query::class, $q);
        $this->assertSame(2, $q->count());
        $this->assertSame('bar', $q->get('foo')->match(
            static fn($foo) => $foo,
            static fn() => null,
        ));
        $this->assertSame('foo', $q->get('baz')->match(
            static fn($baz) => $baz,
            static fn() => null,
        ));
    }
}
