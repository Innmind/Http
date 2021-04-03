<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;

/**
 * @extends Header<CacheControlValue>
 * @implements HeaderInterface<CacheControlValue>
 */
final class CacheControl extends Header implements HeaderInterface
{
    public function __construct(CacheControlValue $first, CacheControlValue ...$values)
    {
        parent::__construct('Cache-Control', $first, ...$values);
    }
}
