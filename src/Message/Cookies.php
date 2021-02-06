<?php
declare(strict_types = 1);

namespace Innmind\Http\Message;

use Innmind\Http\Exception\CookieNotFound;
use Innmind\Immutable\Map;
use function Innmind\Immutable\assertMap;

final class Cookies implements \Countable
{
    /** @var Map<string, string> */
    private Map $cookies;

    public function __construct(Map $cookies = null)
    {
        /** @var Map<string, string> */
        $cookies = $cookies ?? Map::of('string', 'string');

        assertMap('string', 'string', $cookies, 1);

        $this->cookies = $cookies;
    }

    /**
     * @throws CookieNotFound
     */
    public function get(string $name): string
    {
        if (!$this->contains($name)) {
            throw new CookieNotFound($name);
        }

        return $this->cookies->get($name);
    }

    public function contains(string $name): bool
    {
        return $this->cookies->contains($name);
    }

    /**
     * @param callable(string, string): void $function
     */
    public function foreach(callable $function): void
    {
        $this->cookies->foreach($function);
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
