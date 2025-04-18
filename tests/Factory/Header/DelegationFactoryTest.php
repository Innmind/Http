<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\DelegationFactory,
    Factory\Header\AgeFactory,
    Factory\Header\AllowFactory,
    Factory\HeaderFactory,
    Header\Allow,
};
use Innmind\Immutable\{
    Map,
    Str,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class DelegationFactoryTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            HeaderFactory::class,
            new DelegationFactory(Map::of()),
        );
    }

    public function testMake()
    {
        $name = Str::of('Allow');
        $value = Str::of('put');
        $factory = new DelegationFactory(
            Map::of()
                ->put('allow', new AllowFactory)
                ->put('foo', new AgeFactory),
        );

        $header = ($factory)($name, $value)->match(
            static fn($header) => $header,
            static fn() => null,
        );

        $this->assertInstanceOf(Allow::class, $header);
    }
}
