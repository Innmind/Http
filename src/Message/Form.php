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
     * @param scalar $key
     *
     * @throws FormParameterNotFoundException
     */
    public function get($key): Parameter
    {
        if (!$this->contains($key)) {
            throw new FormParameterNotFound;
        }

        return $this->parameters->get($key);
    }

    /**
     * @param scalar $key
     */
    public function contains($key): bool
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
