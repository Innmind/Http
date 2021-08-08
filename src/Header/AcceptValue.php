<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\DomainException;
use Innmind\Immutable\{
    Str,
    Map,
    Sequence,
};
use function Innmind\Immutable\join;

/**
 * @psalm-immutable
 */
final class AcceptValue extends Value\Value
{
    private string $type;
    private string $subType;
    /** @var Map<string, Parameter> */
    private Map $parameters;

    public function __construct(
        string $type,
        string $subType,
        Parameter ...$parameters
    ) {
        $media = Str::of('%s/%s')->sprintf($type, $subType);
        /** @var Map<string, Parameter> */
        $this->parameters = Map::of('string', Parameter::class);

        if (
            !$media->matches('~^\*/\*$~') &&
            !$media->matches('~^[\w\-.]+/\*$~') &&
            !$media->matches('~^[\w\-.]+/[\w\-.]+$~')
        ) {
            throw new DomainException($media->toString());
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
            static fn(Parameter $paramater): \Generator => yield $paramater->toString(),
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
