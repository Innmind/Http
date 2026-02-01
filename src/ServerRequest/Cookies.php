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
final class Cookies implements \Countable
{
    /**
     * @param Map<string, string> $cookies
     */
    private function __construct(private Map $cookies)
    {
    }

    /**
     * @psalm-pure
     *
     * @param Map<string, string>|null $cookies
     */
    #[\NoDiscard]
    public static function of(?Map $cookies = null): self
    {
        return new self($cookies ?? Map::of());
    }

    /**
     * @return Maybe<string>
     */
    #[\NoDiscard]
    public function get(string $name): Maybe
    {
        return $this->cookies->get($name);
    }

    #[\NoDiscard]
    public function contains(string $name): bool
    {
        return $this->cookies->contains($name);
    }

    /**
     * @param callable(string, string): void $function
     */
    #[\NoDiscard]
    public function foreach(callable $function): SideEffect
    {
        return $this->cookies->foreach($function);
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
        return $this->cookies->reduce($carry, $reducer);
    }

    #[\Override]
    #[\NoDiscard]
    public function count(): int
    {
        return $this->cookies->size();
    }
}
