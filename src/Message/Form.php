<?php
declare(strict_types = 1);

namespace Innmind\Http\Message;

use Innmind\Http\{
    Message\Form\Parameter,
    Exception\FormParameterNotFound,
};
use Innmind\Immutable\{
    Map,
    SideEffect,
};

/**
 * @psalm-immutable
 */
final class Form implements \Countable
{
    /** @var Map<string, Parameter> */
    private Map $parameters;

    public function __construct(Parameter ...$parameters)
    {
        /** @var Map<string, Parameter> */
        $this->parameters = Map::of();

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
     * @throws FormParameterNotFound
     */
    public function get(string $key): Parameter
    {
        return $this->parameters->get($key)->match(
            static fn($parameter) => $parameter,
            static fn() => throw new FormParameterNotFound($key),
        );
    }

    public function contains(string $key): bool
    {
        return $this->parameters->contains($key);
    }

    /**
     * @param callable(Parameter): void $function
     */
    public function foreach(callable $function): SideEffect
    {
        return $this->parameters->values()->foreach($function);
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

    public function count()
    {
        return $this->parameters->size();
    }
}
