<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\CacheControlValue;

use Innmind\Http\Header\CacheControlValue;

/**
 * @see https://tools.ietf.org/html/rfc8246
 */
final class Immutable implements CacheControlValue
{
    public function __toString(): string
    {
        return 'immutable';
    }
}
