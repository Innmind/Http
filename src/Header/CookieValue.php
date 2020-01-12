<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\DomainException;
use Innmind\Immutable\Map;
use function Innmind\Immutable\unwrap;

final class CookieValue extends Value\Value
{
    private Map $parameters;

    public function __construct(Parameter ...$parameters)
    {
        $this->parameters = Map::of('string', Parameter::class);

        foreach ($parameters as $paramater) {
            $this->parameters = $this->parameters->put(
                $paramater->name(),
                $paramater
            );
        }

        parent::__construct(\implode(
            '; ',
            \array_map(
                fn(Parameter $paramater): string => $paramater->toString(),
                unwrap($this->parameters->values()),
            ),
        ));
    }

    /**
     * @return Map<string, Parameter>
     */
    public function parameters(): Map
    {
        return $this->parameters;
    }
}
