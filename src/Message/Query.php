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

    public function __construct(Parameter ...$parameters)
    {
        $this->parameters = Map::of('string', Parameter::class);

        foreach ($parameters as $parameter) {
            $this->parameters = $this->parameters->put(
                $parameter->name(),
                $parameter,
            );
        }
    }

    public static function of(Parameter ...$parameters): self
    {
        return new self(...$parameters);
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
        if (!$this->contains($name)) {
            throw new QueryParameterNotFound;
        }

        return $this->parameters->get($name);
    }

    public function contains(string $name): bool
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
