<?php
declare(strict_types = 1);

namespace Innmind\Http\Headers;

use Innmind\Http\{
    Headers as HeadersInterface,
    Header,
    Exception\InvalidArgumentException,
    Exception\HeaderNotFoundException
};
use Innmind\Immutable\{
    MapInterface,
    Pair,
    Str,
    Map
};

final class Headers implements HeadersInterface
{
    private $headers;

    public function __construct(MapInterface $headers = null)
    {
        $headers = $headers ?? new Map('string', Header::class);

        if (
            (string) $headers->keyType() !== 'string' ||
            (string) $headers->valueType() !== Header::class
        ) {
            throw new InvalidArgumentException;
        }

        $this->headers = $headers->map(function(string $name, Header $header) {
            return new Pair(
                (string) (new Str($name))->toLower(),
                $header
            );
        });
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $name): Header
    {
        if (!$this->has($name)) {
            throw new HeaderNotFoundException;
        }

        return $this->headers->get((string) (new Str($name))->toLower());
    }

    /**
     * {@inheritdoc}
     */
    public function has(string $name): bool
    {
        return $this->headers->contains((string) (new Str($name))->toLower());
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return $this->headers->current();
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return $this->headers->key();
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        $this->headers->next();
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->headers->rewind();
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return $this->headers->valid();
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return $this->headers->size();
    }
}
