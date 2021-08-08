<?php
declare(strict_types = 1);

namespace Innmind\Http\Message;

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
    /** @var Map<string, string> */
    private Map $cookies;

    public function __construct(Map $cookies = null)
    {
        /** @var Map<string, string> */
        $cookies = $cookies ?? Map::of();

        $this->cookies = $cookies;
    }

    /**
     * @return Maybe<string>
     */
    public function get(string $name): Maybe
    {
        return $this->cookies->get($name);
    }

    public function contains(string $name): bool
    {
        return $this->cookies->contains($name);
    }

    /**
     * @param callable(string, string): void $function
     */
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
    public function reduce($carry, callable $reducer)
    {
        return $this->cookies->reduce($carry, $reducer);
    }

    public function count()
    {
        return $this->cookies->size();
    }
}
