<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\Factory\{
    Header\Factories,
    Header\TryFactory,
    HeaderFactory
};
use Innmind\Immutable\MapInterface;
use PHPUnit\Framework\TestCase;

class FactoriesTest extends TestCase
{
    public function testAll()
    {
        $all = Factories::all();

        $this->assertInstanceOf(MapInterface::class, $all);
        $this->assertSame('string', (string) $all->keyType());
        $this->assertSame(HeaderFactory::class, (string) $all->valueType());
        $this->assertCount(25, $all);
        $this->assertSame($all, Factories::all());
    }

    public function testDefault()
    {
        $factory = Factories::default();

        $this->assertInstanceOf(TryFactory::class, $factory);
        $this->assertSame($factory, Factories::default());
    }
}
