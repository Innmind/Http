<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

/**
 * @extends Header<CacheControlValue>
 */
final class CacheControl extends Header
{
    public function __construct(CacheControlValue $first, CacheControlValue ...$values)
    {
        parent::__construct('Cache-Control', $first, ...$values);
    }
}
