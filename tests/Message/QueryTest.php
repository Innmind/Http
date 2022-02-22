<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Message;

use Innmind\Http\Message\Query;
use PHPUnit\Framework\TestCase;

class QueryTest extends TestCase
{
    public function testInterface()
    {
        $query = Query::of([
            42 => '24',
            'foo' => 'bar',
        ]);

        $this->assertFalse($query->contains('24'));
        $this->assertTrue($query->contains(42));
        $this->assertSame('24', $query->get(42)->match(
            static fn($value) => $value,
            static fn() => null,
        ));
        $this->assertSame(2, $query->count());
        $this->assertSame(
            [
                42 => '24',
                'foo' => 'bar',
            ],
            $query->data(),
        );
    }

    public function testReturnNothingWhenAccessingUnknownParameter()
    {
        $this->assertNull(Query::of([])->get('foo')->match(
            static fn($foo) => $foo,
            static fn() => null,
        ));
    }

    public function testList()
    {
        $this->assertSame(
            [1, 2, 3],
            Query::of(['foo' => [1, 2, 3]])->list('foo')->match(
                static fn($list) => $list->data(),
                static fn() => null,
            ),
        );
        $this->assertNull(
            Query::of(['foo' => 'bar'])->list('foo')->match(
                static fn($list) => $list,
                static fn() => null,
            ),
        );
        $this->assertNull(
            Query::of(['foo' => [0 => 1, 2 => 3]])->list('foo')->match(
                static fn($list) => $list,
                static fn() => null,
            ),
        );
    }

    public function testDictionary()
    {
        $this->assertNull(
            Query::of(['foo' => [1, 2, 3]])->dictionary('foo')->match(
                static fn($list) => $list,
                static fn() => null,
            ),
        );
        $this->assertNull(
            Query::of(['foo' => 'bar'])->dictionary('foo')->match(
                static fn($list) => $list,
                static fn() => null,
            ),
        );
        $this->assertSame(
            [0 => 1, 2 => 3],
            Query::of(['foo' => [0 => 1, 2 => 3]])->dictionary('foo')->match(
                static fn($list) => $list->data(),
                static fn() => null,
            ),
        );
    }

    public function testNestedGet()
    {
        $query = Query::of([
            'foo' => [
                'bar' => [
                    'baz' => '42',
                ],
            ],
        ]);

        $this->assertSame(
            '42',
            $query
                ->dictionary('foo')
                ->flatMap(static fn($foo) => $foo->dictionary('bar'))
                ->flatMap(static fn($bar) => $bar->get('baz'))
                ->match(
                    static fn($baz) => $baz,
                    static fn() => null,
                ),
        );
    }
}
