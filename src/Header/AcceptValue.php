<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\DomainException;
use Innmind\Immutable\{
    Str,
    MapInterface,
    Map
};

final class AcceptValue extends HeaderValue\HeaderValue
{
    private $type;
    private $subType;
    private $parameters;

    public function __construct(
        string $type,
        string $subType,
        MapInterface $parameters = null
    ) {
        $media = (new Str('%s/%s'))->sprintf($type, $subType);
        $parameters = $parameters ?? new Map('string', Parameter::class);

        if (
            !$media->matches('~^\*/\*$~') &&
            !$media->matches('~^[\w\-.]+/\*$~') &&
            !$media->matches('~^[\w\-.]+/[\w\-.]+$~')
        ) {
            throw new DomainException;
        }

        if (
            (string) $parameters->keyType() !== 'string' ||
            (string) $parameters->valueType() !== Parameter::class
        ) {
            throw new \TypeError(sprintf(
                'Argument 3 must be of type MapInterface<string, %s>',
                Parameter::class
            ));
        }

        $this->type = $type;
        $this->subType = $subType;
        $this->parameters = $parameters;

        $parameters = $parameters->values()->join(';');
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
