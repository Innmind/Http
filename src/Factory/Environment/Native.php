<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory\Environment;

use Innmind\Http\ServerRequest\Environment;
use Innmind\Immutable\Map;

/**
 * @internal
 * @psalm-immutable
 */
final class Native
{
    /**
     * @param array<string, string> $env
     */
    private function __construct(
        private array $env,
    ) {
    }

    public function __invoke(): Environment
    {
        /** @var Map<string, string> */
        $map = Map::of();

        foreach ($this->env as $name => $value) {
            $map = ($map)($name, $value);
        }

        return Environment::of($map);
    }

    public static function new(): self
    {
        return new self(\getenv());
    }
}
