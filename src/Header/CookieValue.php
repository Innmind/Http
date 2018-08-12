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

    public function __construct(Parameter ...$paramaters)
    {
        $this->paramaters = new Map('string', Parameter::class);

        foreach ($paramaters as $paramater) {
            $this->paramaters = $this->paramaters->put(
                $paramater->name(),
                $paramater
            );
        }

        parent::__construct((string) $this->paramaters->values()->join('; '));
    }

    /**
     * @return MapInterface<string, Parameter>
     */
    public function parameters(): MapInterface
    {
        return $this->paramaters;
    }
}
