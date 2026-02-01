<?php
declare(strict_types = 1);

namespace Innmind\Http\ServerRequest;

use Innmind\Immutable\{
    Map,
    SideEffect,
    Maybe,
};

/**
 * @psalm-immutable
 */
final class Environment implements \Countable
{
    /** @var Map<string, string> */
    private Map $variables;

    /**
     * @param Map<string, string>|null $variables
     */
    private function __construct(?Map $variables = null)
    {
        /** @var Map<string, string> */
        $variables = $variables ?? Map::of();

        $this->variables = $variables;
    }

    /**
     * @psalm-pure
     *
     * @param Map<string, string>|null $variables
     */
    #[\NoDiscard]
    public static function of(?Map $variables = null): self
    {
        return new self($variables);
    }

    /**
     * @return Maybe<string>
     */
    #[\NoDiscard]
    public function get(string $name): Maybe
    {
        return $this->variables->get($name);
    }

    #[\NoDiscard]
    public function contains(string $name): bool
    {
        return $this->variables->contains($name);
    }

    /**
     * @param callable(string, string): void $function
     */
    #[\NoDiscard]
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
    #[\NoDiscard]
    public function reduce($carry, callable $reducer)
    {
        return $this->variables->reduce($carry, $reducer);
    }

    #[\Override]
    #[\NoDiscard]
    public function count(): int
    {
        return $this->variables->size();
    }
}
