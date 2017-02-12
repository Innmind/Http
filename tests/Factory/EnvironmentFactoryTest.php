<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory;

use Innmind\Http\{
    Factory\EnvironmentFactory,
    Factory\EnvironmentFactoryInterface,
    Message\EnvironmentInterface
};
use Innmind\Immutable\Map;
use PHPUnit\Framework\TestCase;

class EnvironmentFactoryTest extends TestCase
{
    public function testMake()
    {
        $f = new EnvironmentFactory;

        $this->assertInstanceOf(EnvironmentFactoryInterface::class, $f);

        $e = $f->make();

        $this->assertInstanceOf(EnvironmentInterface::class, $e);
    }
}
