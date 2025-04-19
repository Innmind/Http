<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header;

/**
 * @psalm-immutable
 */
final class CacheControl implements Provider
{
    private Header $header;

    public function __construct(CacheControlValue $first, CacheControlValue ...$values)
    {
        $this->header = new Header('Cache-Control', $first, ...$values);
    }

    #[\Override]
    public function toHeader(): Header
    {
        return $this->header;
    }
}
