<?php
declare(strict_types = 1);

namespace Innmind\Http\Tests\Factory;

use Innmind\Http\{
    Factory\QueryFactory,
    Factory\QueryFactoryInterface,
    Message\QueryInterface
};
use Innmind\Immutable\Map;

class QueryFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testMake()
    {
        $f = new QueryFactory;

        $this->assertInstanceOf(QueryFactoryInterface::class, $f);

        $q = $f->make();

        $this->assertInstanceOf(QueryInterface::class, $q);
        $this->assertSame(0, $q->count());
    }
}
