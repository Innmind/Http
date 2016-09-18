<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\CacheControlValue;

use Innmind\Http\Header\CacheControlValueInterface;

final class NoTransform implements CacheControlValueInterface
{
    public function __toString(): string
    {
        return 'no-transform';
    }
}
