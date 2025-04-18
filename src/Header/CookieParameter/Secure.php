<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\CookieParameter;

use Innmind\Http\Header\Parameter;

/**
 * @psalm-immutable
 */
final class Secure implements Parameter
{
    private Parameter $parameter;

    public function __construct()
    {
        $this->parameter = new Parameter\Parameter('Secure', '');
    }

    #[\Override]
    public function name(): string
    {
        return $this->parameter->name();
    }

    #[\Override]
    public function value(): string
    {
        return $this->parameter->value();
    }

    #[\Override]
    public function toString(): string
    {
        return $this->parameter->toString();
    }
}
