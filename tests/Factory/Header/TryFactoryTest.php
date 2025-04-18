<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Header;

use Innmind\Http\{
    Factory\Header\TryFactory,
    Factory\Header\AllowFactory,
    Factory\Header\AgeFactory,
    Factory\HeaderFactory,
    Header,
    Header\Allow,
    Header\Age,
};
use Innmind\Immutable\{
    Str,
    Maybe,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class TryFactoryTest extends TestCase
{
    public function testMake()
    {
        $name = Str::of('Age');
        $value = Str::of('42');
        $factory = new TryFactory(new AgeFactory);

        $this->assertInstanceOf(Age::class, ($factory)($name, $value));
    }

    public function testMakeViaFallback()
    {
        $name = Str::of('Allow');
        $value = Str::of('PUT');
        $factory = new TryFactory(
            new AgeFactory,
            static fn($name, $value) => (new AllowFactory)($name, $value)->match(
                static fn($header) => $header,
                static fn() => null,
            ),
        );

        $this->assertInstanceOf(Allow::class, ($factory)($name, $value));
    }
}
