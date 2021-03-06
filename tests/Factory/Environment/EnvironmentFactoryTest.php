<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Environment;

use Innmind\Http\{
    Factory\Environment\EnvironmentFactory,
    Factory\EnvironmentFactory as EnvironmentFactoryInterface,
    Message\Environment
};
use PHPUnit\Framework\TestCase;

class EnvironmentFactoryTest extends TestCase
{
    public function testMake()
    {
        $f = new EnvironmentFactory;

        $this->assertInstanceOf(EnvironmentFactoryInterface::class, $f);

        $e = ($f)();

        $this->assertInstanceOf(Environment::class, $e);
    }
}
