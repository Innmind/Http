<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\CacheControlValue;

use Innmind\Http\Header\CacheControlValue;

/**
 * @see https://tools.ietf.org/html/rfc8246
 * @psalm-immutable
 */
final class Immutable implements CacheControlValue
{
    public function toString(): string
    {
        return 'immutable';
    }
}
