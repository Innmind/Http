<?php
declare(strict_types = 1);

namespace Innmind\Http\Message;

use Innmind\Http\{
    Message\Form\ParameterInterface,
    Exception\InvalidArgumentException,
    Exception\FormParameterNotFoundException
};
use Innmind\Immutable\MapInterface;

final class Form implements FormInterface
{
    private $parameters;

    public function __construct(MapInterface $parameters)
    {
        if (
            (string) $parameters->keyType() !== 'scalar' ||
            (string) $parameters->valueType() !== ParameterInterface::class
        ) {
            throw new InvalidArgumentException;
        }

        $this->parameters = $parameters;
    }

    /**
     * {@inheritdoc}
     */
    public function get($key): ParameterInterface
    {
        if (!$this->has($key)) {
            throw new FormParameterNotFoundException;
        }

        return $this->parameters->get($key);
    }

    /**
     * {@inheritdoc}
     */
    public function has($key): bool
    {
        return $this->parameters->contains($key);
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
