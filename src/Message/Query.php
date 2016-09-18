<?php
declare(strict_types = 1);

namespace Innmind\Http\Message;

use Innmind\Http\{
    Message\Query\ParameterInterface,
    Exception\InvalidArgumentException,
    Exception\QueryParameterNotFoundException
};
use Innmind\Immutable\MapInterface;

final class Query implements QueryInterface
{
    private $parameters;

    public function __construct(MapInterface $parameters)
    {
        if (
            (string) $parameters->keyType() !== 'string' ||
            (string) $parameters->valueType() !== ParameterInterface::class
        ) {
            throw new InvalidArgumentException;
        }

        $this->parameters = $parameters;
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $name): ParameterInterface
    {
        if (!$this->has($name)) {
            throw new QueryParameterNotFoundException;
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