<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Environment;

use Innmind\Http\{
    Factory\EnvironmentFactory as EnvironmentFactoryInterface,
    ServerRequest\Environment,
};
use Innmind\Immutable\Map;

/**
 * @psalm-immutable
 */
final class EnvironmentFactory implements EnvironmentFactoryInterface
{
    /**
     * @param array<string, string> $env
     */
    public function __construct(
        private array $env,
    ) {
    }

    #[\Override]
    public function __invoke(): Environment
    {
        /** @var Map<string, string> */
        $map = Map::of();

        foreach ($this->env as $name => $value) {
            $map = ($map)($name, $value);
        }

        return Environment::of($map);
    }

    public static function default(): self
    {
        return new self(\getenv());
    }
}
