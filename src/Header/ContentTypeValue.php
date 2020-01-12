<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\DomainException;
use Innmind\Immutable\{
    Str,
    Map,
};
use function Innmind\Immutable\join;

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
            $this->parameters = ($this->parameters)(
                $parameter->name(),
                $parameter,
            );
        }

        $this->type = $type;
        $this->subType = $subType;

        $parameters = $this->parameters->values()->toSequenceOf(
            'string',
            fn(Parameter $paramater): \Generator => yield $paramater->toString(),
        );
        $parameters = join(';', $parameters);
        $parameters = !$parameters->empty() ? $parameters->prepend(';') : $parameters;

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
