<?php
declare(strict_types = 1);

namespace Innmind\Http\Message;

use Innmind\Http\Exception\EnvironmentVariableNotFound;
use Innmind\Immutable\{
    Map,
    SideEffect,
};

/**
 * @psalm-immutable
 */
final class Environment implements \Countable
{
    /** @var Map<string, string> */
    private Map $variables;

    public function __construct(Map $variables = null)
    {
        /** @var Map<string, string> */
        $variables = $variables ?? Map::of();

        $this->variables = $variables;
    }

    /**
     * @throws EnvironmentVariableNotFound
     */
    public function get(string $name): string
    {
        return $this->variables->get($name)->match(
            static fn($env) => $env,
            static fn() => throw new EnvironmentVariableNotFound($name),
        );
    }

    public function contains(string $name): bool
    {
        return $this->variables->contains($name);
    }

    /**
     * @param callable(string, string): void $function
     */
    public function foreach(callable $function): SideEffect
    {
        return $this->variables->foreach($function);
    }

    /**
     * @template R
     *
     * @param R $carry
     * @param callable(R, string, string): R $reducer
     *
     * @return R
     */
    public function reduce($carry, callable $reducer)
    {
        return $this->variables->reduce($carry, $reducer);
    }

    public function count()
    {
        return $this->variables->size();
    }
}
