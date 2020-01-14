<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\CacheControlValue;

use Innmind\Http\Header\CacheControlValue;

final class PublicCache implements CacheControlValue
{
    public function toString(): string
    {
        return 'public';
    }
}
