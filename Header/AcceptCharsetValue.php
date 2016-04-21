<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\InvalidArgumentException;
use Innmind\Immutable\StringPrimitive as Str;

final class AcceptCharsetValue extends HeaderValue
{
    const PATTERN = '~^([a-zA-Z0-9\-_:\(\)]+|\*)(; ?\q=\d+(\.\d+)?)?$~';

    public function __construct(string $value)
    {
        if (!(new Str($value))->match(self::PATTERN)) {
            throw new InvalidArgumentException;
        }

        parent::__construct($value);
    }
}
