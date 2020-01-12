<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Environment;

use Innmind\Http\{
    Factory\EnvironmentFactory as EnvironmentFactoryInterface,
    Message\Environment,
};
use Innmind\Immutable\Map;

final class EnvironmentFactory implements EnvironmentFactoryInterface
{
    public function __invoke(): Environment
    {
        $map = Map::of('string', 'scalar');

        foreach (\getenv() as $name => $value) {
            if (!\is_scalar($value)) {
                continue;
            }

            $map = ($map)($name, $value);
        }

        return new Environment($map);
    }
}
