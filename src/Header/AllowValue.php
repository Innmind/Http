<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\{
    Message\MethodInterface,
    Exception\InvalidArgumentException
};
use Innmind\Immutable\Str;

final class AllowValue extends HeaderValue
{
    public function __construct(string $value)
    {
        if (!defined(MethodInterface::class.'::'.$value)) {
            throw new InvalidArgumentException;
        }

        parent::__construct($value);
    }
}
