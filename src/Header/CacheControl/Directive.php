<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\CacheControl;

/**
 * @psalm-immutable
 */
enum Directive
{
    /** @see https://tools.ietf.org/html/rfc8246 */
    case immutable;
    case mustRevalidate;
    case noStore;
    case noTransform;
    case onlyIfCached;
    case proxyRevalidate;
    case public;

    public function toString(): string
    {
        return match ($this) {
            self::immutable => 'immutable',
            self::mustRevalidate => 'must-revalidate',
            self::noStore => 'no-store',
            self::noTransform => 'no-transform',
            self::onlyIfCached => 'only-if-cached',
            self::proxyRevalidate => 'proxy-revalidate',
            self::public => 'public',
        };
    }
}
