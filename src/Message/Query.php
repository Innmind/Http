<?php
declare(strict_types = 1);

namespace Innmind\Http\Message;

use Innmind\Http\{
    Message\Query\Parameter,
    Exception\QueryParameterNotFound,
};
use Innmind\Immutable\{
    Map,
    SideEffect,
};

/**
 * @psalm-immutable
 */
final class Query implements \Countable
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
     * @throws QueryParameterNotFound
     */
    public function get(string $name): Parameter
    {
        return $this->parameters->get($name)->match(
            static fn($parameter) => $parameter,
            static fn() => throw new QueryParameterNotFound($name),
        );
    }

    public function contains(string $name): bool
    {
        return $this->parameters->contains($name);
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
