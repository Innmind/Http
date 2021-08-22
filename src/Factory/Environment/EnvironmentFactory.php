<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Environment;

use Innmind\Http\{
    Factory\EnvironmentFactory as EnvironmentFactoryInterface,
    Message\Environment,
};
use Innmind\Immutable\Map;

/**
 * @psalm-immutable
 */
final class EnvironmentFactory implements EnvironmentFactoryInterface
{
    /** @var array<string, string> */
    private array $env;

    /**
     * @param array<string, string> $env
     */
    public function __construct(array $env)
    {
        $this->env = $env;
    }

    public function __invoke(): Environment
    {
        /** @var Map<string, string> */
        $map = Map::of();

        foreach ($this->env as $name => $value) {
            $map = ($map)($name, $value);
        }

        return new Environment($map);
    }

    public static function default(): self
    {
        return new self(\getenv());
    }
}
