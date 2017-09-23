<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\{
    Message\Method,
    Exception\DomainException
};
use Innmind\Immutable\Str;

final class AllowValue extends Value\Value
{
    public function __construct(string $value)
    {
        if (!defined(Method::class.'::'.$value)) {
            throw new DomainException;
        }

        parent::__construct($value);
    }
}
