<?php
declare(strict_types = 1);

namespace Innmind\Http\Message;

use Innmind\Http\{
    Exception\CookieNotFound
};
use Innmind\Immutable\{
    MapInterface,
    Map
};
use function Innmind\Immutable\assertMap;

final class Cookies implements \Countable
{
    private Map $cookies;

    public function __construct(MapInterface $cookies = null)
    {
        $cookies = $cookies ?? new Map('string', 'scalar');

        assertMap('string', 'scalar', $cookies, 1);

        $this->cookies = $cookies;
    }

    /**
     * @throws CookieNotFoundException
     *
     * @return mixed
     */
    public function get(string $name)
    {
        if (!$this->contains($name)) {
            throw new CookieNotFound;
        }

        return $this->cookies->get($name);
    }

    public function contains(string $name): bool
    {
        return $this->cookies->contains($name);
    }

    /**
     * @param callable(string, scalar): void $function
     */
    public function foreach(callable $function): void
    {
        $this->cookies->foreach($function);
    }

    /**
     * @template R
     *
     * @param R $carry
     * @param callable(R, string, scalar): R $reducer
     *
     * @return R
     */
    public function reduce($carry, callable $reducer)
    {
        return $this->cookies->reduce($carry, $reducer);
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return $this->cookies->size();
    }
}
