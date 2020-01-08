<?php
declare(strict_types = 1);

namespace Innmind\Http\Message;

use Innmind\Http\{
    Message\Query\Parameter,
    Exception\QueryParameterNotFound
};
use Innmind\Immutable\{
    MapInterface,
    Map,
    Sequence
};

final class Query implements \Iterator, \Countable
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

    public static function of(Parameter ...$parameters): self
    {
        return new self(
            Sequence::of(...$parameters)->reduce(
                new Map('string', Parameter::class),
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
     * @param string $name
     *
     * @throws QueryParameterFoundException
     *
     * @return Parameter
     */
    public function get(string $name): Parameter
    {
        if (!$this->has($name)) {
            throw new QueryParameterNotFound;
        }

        return $this->parameters->get($name);
    }

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
