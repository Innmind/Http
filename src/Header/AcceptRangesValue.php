<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\InvalidArgumentException;
use Innmind\Immutable\StringPrimitive as Str;

final class AcceptRangesValue extends HeaderValue
{
    public function __construct(string $range)
    {
        if (!(new Str($range))->match('~^\w+$~')) {
            throw new InvalidArgumentException;
        }

        parent::__construct($range);
    }
}
