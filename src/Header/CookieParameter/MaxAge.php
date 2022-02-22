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
final class MaxAge implements Parameter
{
    private Parameter $parameter;

    public function __construct(int $number)
    {
        if ($number < 1) {
            throw new DomainException((string) $number);
        }

        $this->parameter = new Parameter\Parameter('Max-Age', (string) $number);
    }

    /**
     * @psalm-pure
     */
    public static function expire(): Parameter
    {
        return new Parameter\Parameter('Max-Age', '-1');
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
