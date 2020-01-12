<?php
declare(strict_types = 1);

namespace Innmind\Http\Message;

use Innmind\Http\{
    Message\Form\Parameter,
    Exception\FormParameterNotFound,
};
use Innmind\Immutable\Map;

final class Form implements \Countable
{
    private Map $parameters;

    public function __construct(Parameter ...$parameters)
    {
        $this->parameters = Map::of('string', Parameter::class);

        foreach ($parameters as $parameter) {
            $this->parameters = ($this->parameters)(
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
     * @throws FormParameterNotFoundException
     */
    public function get(string $key): Parameter
    {
        if (!$this->contains($key)) {
            throw new FormParameterNotFound($key);
        }

        return $this->parameters->get($key);
    }

    public function contains(string $key): bool
    {
        return $this->parameters->contains($key);
    }

    /**
     * @param callable(Parameter): void $function
     */
    public function foreach(callable $function): void
    {
        $this->parameters->values()->foreach($function);
    }

    /**
     * @template R
     *
     * @param R $carry
     * @param callable(R, Parameter): R $reducer
     *
     * @return R
     */
    public function reduce($carry, callable $reducer)
    {
        return $this->parameters->values()->reduce($carry, $reducer);
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return $this->parameters->size();
    }
}
