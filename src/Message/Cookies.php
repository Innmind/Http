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

final class Cookies implements \Iterator, \Countable
{
    private $cookies;

    public function __construct(MapInterface $cookies = null)
    {
        $cookies = $cookies ?? new Map('string', 'scalar');

        if (
            (string) $cookies->keyType() !== 'string' ||
            (string) $cookies->valueType() !== 'scalar'
        ) {
            throw new \TypeError(
                'Argument 1 must be of type MapInterface<string, scalar>'
            );
        }

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
     * {@inheritdoc}
     */
    public function current()
    {
        return $this->cookies->current();
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return $this->cookies->key();
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        $this->cookies->next();
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->cookies->rewind();
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return $this->cookies->valid();
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return $this->cookies->size();
    }
}
