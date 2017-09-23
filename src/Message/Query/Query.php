<?php
declare(strict_types = 1);

namespace Innmind\Http\Message\Query;

use Innmind\Http\{
    Message\Query as QueryInterface,
    Exception\QueryParameterNotFound
};
use Innmind\Immutable\{
    MapInterface,
    Map
};

final class Query implements QueryInterface
{
    private $parameters;

    public function __construct(MapInterface $parameters = null)
    {
        $parameters = $parameters ?? new Map('string', Parameter::class);

        if (
            (string) $parameters->keyType() !== 'string' ||
            (string) $parameters->valueType() !== Parameter::class
        ) {
            throw new \TypeError(sprintf(
                'Argument 1 must be of type MapInterface<string, %s>',
                Parameter::class
            ));
        }

        $this->parameters = $parameters;
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $name): Parameter
    {
        if (!$this->has($name)) {
            throw new QueryParameterNotFound;
        }

        return $this->parameters->get($name);
    }

    /**
     * {@inheritdoc}
     */
    public function has(string $name): bool
    {
        return $this->parameters->contains($name);
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return $this->parameters->current();
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return $this->parameters->key();
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        $this->parameters->next();
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->parameters->rewind();
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return $this->parameters->valid();
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return $this->parameters->size();
    }
}
