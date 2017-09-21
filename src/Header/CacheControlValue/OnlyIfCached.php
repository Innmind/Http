<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\CacheControlValue;

use Innmind\Http\Header\CacheControlValue;

final class OnlyIfCached implements CacheControlValue
{
    public function __toString(): string
    {
        return 'only-if-cached';
    }
}
