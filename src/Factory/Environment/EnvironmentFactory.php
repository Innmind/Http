<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Environment;

use Innmind\Http\{
    Factory\EnvironmentFactory as EnvironmentFactoryInterface,
    Message\Environment
};
use Innmind\Immutable\Map;

final class EnvironmentFactory implements EnvironmentFactoryInterface
{
    public function make(): Environment
    {
        $map = new Map('string', 'scalar');

        foreach ($_SERVER as $name => $value) {
            if (!is_scalar($value)) {
                continue;
            }

            $map = $map->put(
                $name,
                $value
            );
        }

        return new Environment\Environment($map);
    }
}
