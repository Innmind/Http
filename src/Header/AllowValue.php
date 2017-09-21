<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\{
    Message\Method,
    Exception\InvalidArgumentException
};
use Innmind\Immutable\Str;

final class AllowValue extends HeaderValue\HeaderValue
{
    public function __construct(string $value)
    {
        if (!defined(Method::class.'::'.$value)) {
            throw new InvalidArgumentException;
        }

        parent::__construct($value);
    }
}
