<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\DomainException;
use Innmind\Immutable\{
    Str,
    Map,
};
use function Innmind\Immutable\unwrap;

final class ContentTypeValue extends Value\Value
{
    private string $type;
    private string $subType;
    private Map $parameters;

    public function __construct(
        string $type,
        string $subType,
        Parameter ...$parameters
    ) {
        $media = Str::of('%s/%s')->sprintf($type, $subType);
        $this->parameters = Map::of('string', Parameter::class);

        if (!$media->matches('~^[\w\-.]+/[\w\-.]+$~')) {
            throw new DomainException;
        }

        foreach ($parameters as $parameter) {
            $this->parameters = $this->parameters->put(
                $parameter->name(),
                $parameter,
            );
        }

        $this->type = $type;
        $this->subType = $subType;

        $parameters = Str::of(\implode(
            ';',
            \array_map(
                fn(Parameter $paramater): string => $paramater->toString(),
                unwrap($this->parameters->values()),
            ),
        ));
        $parameters = $parameters->length() > 0 ? $parameters->prepend(';') : $parameters;

        parent::__construct(
            $media
                ->append($parameters->toString())
                ->toString(),
        );
    }

    public function type(): string
    {
        return $this->type;
    }

    public function subType(): string
    {
        return $this->subType;
    }

    /**
     * @return Map<string, Parameter>
     */
    public function parameters(): Map
    {
        return $this->parameters;
    }
}
