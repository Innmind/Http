<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\CacheControlValue;

use Innmind\Http\Header\CacheControlValue;

final class ProxyRevalidate implements CacheControlValue
{
    public function toString(): string
    {
        return 'proxy-revalidate';
    }
}
