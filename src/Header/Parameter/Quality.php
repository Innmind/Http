<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\Parameter;

use Innmind\Http\{
    Header\Parameter as ParameterInterface,
    Exception\DomainException
};

/**
 * @psalm-immutable
 */
final class Quality implements ParameterInterface
{
    private Parameter $parameter;

    public function __construct(float $value)
    {
        if ($value < 0 || $value > 1) {
            throw new DomainException((string) $value);
        }

        $this->parameter = new Parameter('q', (string) $value);
    }

    public function name(): string
    {
        return $this->parameter->name();
    }

    public function value(): string
    {
        return $this->parameter->value();
    }

    public function toString(): string
    {
        return $this->parameter->toString();
    }
}
