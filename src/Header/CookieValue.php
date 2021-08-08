<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Immutable\Map;
use function Innmind\Immutable\join;

/**
 * @psalm-immutable
 */
final class CookieValue implements Value
{
    /** @var Map<string, Parameter> */
    private Map $parameters;

    public function __construct(Parameter ...$parameters)
    {
        /** @var Map<string, Parameter> */
        $this->parameters = Map::of();

        foreach ($parameters as $paramater) {
            $this->parameters = ($this->parameters)(
                $paramater->name(),
                $paramater
            );
        }
    }

    /**
     * @return Map<string, Parameter>
     */
    public function parameters(): Map
    {
        return $this->parameters;
    }

    public function toString(): string
    {
        $parameters = $this->parameters->values()->map(
            static fn($paramater) => $paramater->toString(),
        );

        return join('; ', $parameters)->toString();
    }
}
