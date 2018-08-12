<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\DomainException;
use Innmind\Immutable\{
    MapInterface,
    Map
};

final class CookieValue extends Value\Value
{
    private $parameters;

    public function __construct(Parameter ...$parameters)
    {
        $this->parameters = new Map('string', Parameter::class);

        foreach ($parameters as $paramater) {
            $this->parameters = $this->parameters->put(
                $paramater->name(),
                $paramater
            );
        }

        parent::__construct((string) $this->parameters->values()->join('; '));
    }

    /**
     * @return MapInterface<string, Parameter>
     */
    public function parameters(): MapInterface
    {
        return $this->parameters;
    }
}
