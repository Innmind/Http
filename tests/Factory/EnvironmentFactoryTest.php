<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory;

use Innmind\Http\{
    Factory\EnvironmentFactory,
    Factory\EnvironmentFactoryInterface,
    Message\EnvironmentInterface
};
use Innmind\Immutable\Map;

class EnvironmentFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testMake()
    {
        $f = new EnvironmentFactory;

        $this->assertInstanceOf(EnvironmentFactoryInterface::class, $f);

        $e = $f->make();

        $this->assertInstanceOf(EnvironmentInterface::class, $e);
    }
}
