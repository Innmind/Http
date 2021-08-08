<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\CacheControlValue;

use Innmind\Http\Header\CacheControlValue;

/**
 * @psalm-immutable
 */
final class NoStore implements CacheControlValue
{
    public function toString(): string
    {
        return 'no-store';
    }
}
