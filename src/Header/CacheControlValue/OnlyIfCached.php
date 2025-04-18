<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\CacheControlValue;

use Innmind\Http\Header\CacheControlValue;

/**
 * @psalm-immutable
 */
final class OnlyIfCached implements CacheControlValue
{
    #[\Override]
    public function toString(): string
    {
        return 'only-if-cached';
    }
}
