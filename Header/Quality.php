<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\InvalidArgumentException;
use Innmind\Immutable\StringPrimitive as Str;

final class Quality extends Parameter
{
    public function __construct(float $value)
    {
        if ($value < 0 || $value > 1) {
            throw new InvalidArgumentException;
        }

        parent::__construct('q', (string) $value);
    }
}
