<?php
declare(strict_types = 1);

namespace Innmind\Http\Message;

use Innmind\Http\Message\Query\Parameter;
use Innmind\Immutable\{
    Map,
    SideEffect,
    Maybe,
};

/**
 * @psalm-immutable
 */
final class Query implements \Countable
{
    /** @var Map<string, Parameter> */
    private Map $parameters;

    /**
     * @no-named-arguments
     */
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

    /**
     * @no-named-arguments
     * @psalm-pure
     */
    public static function of(Parameter ...$parameters): self
    {
        return new self(...$parameters);
    }

    /**
     * @return Maybe<Parameter>
     */
    public function get(string $name): Maybe
    {
        return $this->parameters->get($name);
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
