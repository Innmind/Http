<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header;
use Innmind\Immutable\{
    Map,
    Str,
};

/**
 * @psalm-immutable
 */
final class Cookie implements Custom
{
    /**
     * @param Map<string, Parameter> $parameters
     */
    private function __construct(
        private Map $parameters,
    ) {
    }

    /**
     * @no-named-arguments
     * @psalm-pure
     */
    public static function of(Parameter ...$parameters): self
    {
        /** @var Map<string, Parameter> */
        $map = Map::of();

        foreach ($parameters as $paramater) {
            $map = ($map)(
                $paramater->name(),
                $paramater,
            );
        }

        return new self($map);
    }

    /**
     * @return Map<string, Parameter>
     */
    public function parameters(): Map
    {
        return $this->parameters;
    }

    #[\Override]
    public function normalize(): Header
    {
        $parameters = $this->parameters->values()->map(
            static fn($paramater) => $paramater->toString(),
        );

        $value = Str::of('; ')->join($parameters)->toString();

        return Header::of(
            'Cookie',
            Value::of($value),
        );
    }
}
