<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\InvalidArgumentException;
use Innmind\Immutable\StringPrimitive as Str;

final class AcceptValue extends HeaderValue
{
    const PATTERN = '~^(\*/\*|[\w\-.]+/[\w\-.\*]+)(; ?\w+=[\w\-.]+)?$~';

    public function __construct(string $value)
    {
        if (!(new Str($value))->match(self::PATTERN)) {
            throw new InvalidArgumentException;
        }

        parent::__construct($value);
    }
}
