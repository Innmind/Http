<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\CookieParameter;

use Innmind\Http\{
    Header\Parameter,
    Exception\DomainException,
};

/**
 * @psalm-immutable
 */
final class SameSite implements Parameter
{
    private Parameter $parameter;

    public function __construct(string $value)
    {
        if (!\in_array($value, ['Strict', 'Lax'], true)) {
            throw new DomainException($value);
        }

        $this->parameter = new Parameter\Parameter('SameSite', $value);
    }

    public static function strict(): self
    {
        return new self('Strict');
    }

    public static function lax(): self
    {
        return new self('Lax');
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
