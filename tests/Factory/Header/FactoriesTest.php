<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\Factory\{
    Header\Factories,
    Header\TryFactory,
    HeaderFactory
};
use Innmind\TimeContinuum\Earth\Clock;
use Innmind\Immutable\Map;
use PHPUnit\Framework\TestCase;

class FactoriesTest extends TestCase
{
    public function testAll()
    {
        $all = Factories::all(new Clock);

        $this->assertInstanceOf(Map::class, $all);
        $this->assertCount(26, $all);
        $this->assertEquals($all, Factories::all(new Clock));
    }

    public function testDefault()
    {
        $factory = Factories::default(new Clock);

        $this->assertInstanceOf(TryFactory::class, $factory);
        $this->assertEquals($factory, Factories::default(new Clock));
    }
}
