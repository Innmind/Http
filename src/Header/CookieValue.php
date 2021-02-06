<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Immutable\{
    Map,
    Sequence,
};
use function Innmind\Immutable\join;

final class CookieValue extends Value\Value
{
    /** @var Map<string, Parameter> */
    private Map $parameters;

    public function __construct(Parameter ...$parameters)
    {
        /** @var Map<string, Parameter> */
        $this->parameters = Map::of('string', Parameter::class);

        foreach ($parameters as $paramater) {
            $this->parameters = ($this->parameters)(
                $paramater->name(),
                $paramater
            );
        }

        /** @var Sequence<string> */
        $parameters = $this->parameters->values()->toSequenceOf(
            'string',
            static fn(Parameter $paramater): \Generator => yield $paramater->toString(),
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
