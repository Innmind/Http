<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\Factory\{
    Header\Factories,
    Header\DelegationFactory
};
use Innmind\TimeContinuum\Clock;
use Innmind\Immutable\Map;
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class FactoriesTest extends TestCase
{
    public function testAll()
    {
        $all = Factories::all(Clock::live());

        $this->assertInstanceOf(Map::class, $all);
        $this->assertCount(26, $all);
        $this->assertEquals($all, Factories::all(Clock::live()));
    }

    public function testDefault()
    {
        $factory = Factories::default(Clock::live());

        $this->assertInstanceOf(DelegationFactory::class, $factory);
        $this->assertEquals($factory, Factories::default(Clock::live()));
    }
}
