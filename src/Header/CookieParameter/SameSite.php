<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\CookieParameter;

use Innmind\Http\Header\Parameter;

/**
 * @psalm-immutable
 */
final class SameSite implements Parameter
{
    private Parameter $parameter;

    private function __construct(string $value)
    {
        $this->parameter = new Parameter\Parameter('SameSite', $value);
    }

    /**
     * @psalm-pure
     */
    public static function strict(): self
    {
        return new self('Strict');
    }

    /**
     * @psalm-pure
     */
    public static function lax(): self
    {
        return new self('Lax');
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
