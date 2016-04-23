<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\InvalidArgumentException;
use Innmind\Immutable\StringPrimitive as Str;

final class AgeValue extends HeaderValue
{
    public function __construct(int $age)
    {
        if ($age < 0) {
            throw new InvalidArgumentException;
        }

        parent::__construct((string) $age);
    }
}
