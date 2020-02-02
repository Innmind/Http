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
        /** @var Map<string, string> */
        $map = Map::of('string', 'string');

        /**
         * @var string $name
         * @var string $value
         */
        foreach (\getenv() as $name => $value) {
            $map = ($map)($name, $value);
        }

        return new Environment($map);
    }
}
