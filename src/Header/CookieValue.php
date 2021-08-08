<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Immutable\Map;
use function Innmind\Immutable\join;

/**
 * @psalm-immutable
 */
final class CookieValue extends Value\Value
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

        $parameters = $this->parameters->values()->map(
            static fn($paramater) => $paramater->toString(),
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
