<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\CookieParameter;

use Innmind\Http\{
    Header\Parameter\Parameter,
    Exception\DomainException,
};

final class SameSite extends Parameter
{
    public function __construct(string $value)
    {
        if (!\in_array($value, ['Strict', 'Lax'], true)) {
            throw new DomainException($value);
        }

        parent::__construct('SameSite', $value);
    }

    public static function strict(): self
    {
        return new self('Strict');
    }

    public static function lax(): self
    {
        return new self('Lax');
    }
}
