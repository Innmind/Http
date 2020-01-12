<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\DomainException;
use Innmind\Immutable\Map;
use function Innmind\Immutable\join;

final class CookieValue extends Value\Value
{
    private Map $parameters;

    public function __construct(Parameter ...$parameters)
    {
        $this->parameters = Map::of('string', Parameter::class);

        foreach ($parameters as $paramater) {
            $this->parameters = ($this->parameters)(
                $paramater->name(),
                $paramater
            );
        }

        $parameters = $this->parameters->values()->toSequenceOf(
            'string',
            fn(Parameter $paramater): \Generator => yield $paramater->toString(),
        );

        parent::__construct(join('; ', $parameters)->toString());
    }

    /**
     * @return Map<string, Parameter>
     */
    public function parameters(): Map
    {
        return $this->parameters;
    }
}
