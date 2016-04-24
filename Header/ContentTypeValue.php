<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\InvalidArgumentException;
use Innmind\Immutable\{
    StringPrimitive as Str,
    MapInterface
};

final class ContentTypeValue extends HeaderValue
{
    private $type;
    private $subType;
    private $parameters;

    public function __construct(
        string $type,
        string $subType,
        MapInterface $parameters
    ) {
        $media = (new Str('%s/%s'))->sprintf($type, $subType);

        if (!$media->match('~^[\w\-.]+/[\w\-.]+$~')) {
            throw new InvalidArgumentException;
        }

        if (
            (string) $parameters->keyType() !== 'string' ||
            (string) $parameters->valueType() !== ParameterInterface::class
        ) {
            throw new InvalidArgumentException;
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
     * @return MapInterface<string, ParameterInterface>
     */
    public function parameters(): MapInterface
    {
        return $this->parameters;
    }
}
