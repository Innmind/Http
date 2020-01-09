<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\DomainException;
use Innmind\Immutable\{
    Str,
    MapInterface,
    Map
};

final class ContentTypeValue extends Value\Value
{
    private $type;
    private $subType;
    private $parameters;

    public function __construct(
        string $type,
        string $subType,
        Parameter ...$parameters
    ) {
        $media = (new Str('%s/%s'))->sprintf($type, $subType);
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
                $this->parameters->values()->toPrimitive(),
            ),
        ));
        $parameters = $parameters->length() > 0 ? $parameters->prepend(';') : $parameters;

        parent::__construct((string) $media->append((string) $parameters));
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
     * @return MapInterface<string, Parameter>
     */
    public function parameters(): MapInterface
    {
        return $this->parameters;
    }
}
