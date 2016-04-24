<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\CacheControlValue;

use Innmind\Http\Header\CacheControlValueInterface;

final class PublicCache implements CacheControlValueInterface
{
    public function __toString(): string
    {
        return 'public';
    }
}
