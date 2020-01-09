<?php
declare(strict_types = 1);

namespace Innmind\Http\Message;

use Innmind\Http\{
    Message\Form\Parameter,
    Exception\FormParameterNotFound
};
use Innmind\Immutable\{
    MapInterface,
    Map,
    Sequence
};

final class Form implements \Iterator, \Countable
{
    private $parameters;

    public function __construct(MapInterface $parameters = null)
    {
        $parameters = $parameters ?? new Map('scalar', Parameter::class);

        if (
            (string) $parameters->keyType() !== 'scalar' ||
            (string) $parameters->valueType() !== Parameter::class
        ) {
            throw new \TypeError(sprintf(
                'Argument 1 must be of type MapInterface<scalar, %s>',
                Parameter::class
            ));
        }

        $this->parameters = $parameters;
    }

    public static function of(Parameter ...$parameters): self
    {
        return new self(
            Sequence::of(...$parameters)->reduce(
                new Map('scalar', Parameter::class),
                static function(MapInterface $parameters, Parameter $parameter): MapInterface {
                    return $parameters->put(
                        $parameter->name(),
                        $parameter
                    );
                }
            )
        );
    }

    /**
     * @param scalar $key
     *
     * @throws FormParameterNotFoundException
     */
    public function get($key): Parameter
    {
        if (!$this->has($key)) {
            throw new FormParameterNotFound;
        }

        return $this->parameters->get($key);
    }

    /**
     * @param scalar $key
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
