<?php
declare(strict_types = 1);

namespace Innmind\Http;

use Innmind\Http\{
    Header\HeaderInterface,
    Exception\InvalidArgumentException,
    Exception\HeaderNotFoundException
};
use Innmind\Immutable\{
    MapInterface,
    Pair,
    StringPrimitive as Str
};

final class Headers implements HeadersInterface
{
    private $headers;

    public function __construct(MapInterface $headers)
    {
        if (
            (string) $headers->keyType() !== 'string' ||
            (string) $headers->valueType() !== HeaderInterface::class
        ) {
            throw new InvalidArgumentException;
        }

        $this->headers = $headers->map(function(string $name, HeaderInterface $header) {
            return new Pair(
                (string) (new Str($name))->toLower(),
                $header
            );
        });
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $name): HeaderInterface
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
