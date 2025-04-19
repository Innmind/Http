<?php
declare(strict_types = 1);

namespace Tests\Innmind\Http\Factory\Environment;

use Innmind\Http\{
    Factory\EnvironmentFactory,
    ServerRequest\Environment,
};
use Innmind\BlackBox\PHPUnit\Framework\TestCase;

class EnvironmentFactoryTest extends TestCase
{
    public function testMake()
    {
        $f = EnvironmentFactory::default();

        $e = ($f)();

        $this->assertInstanceOf(Environment::class, $e);
    }
}
