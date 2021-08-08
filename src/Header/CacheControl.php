<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Immutable\Set;

/**
 * @implements HeaderInterface<CacheControlValue>
 * @psalm-immutable
 */
final class CacheControl implements HeaderInterface
{
    /** @var Header<CacheControlValue> */
    private Header $header;

    public function __construct(CacheControlValue $first, CacheControlValue ...$values)
    {
        $this->header = new Header('Cache-Control', $first, ...$values);
    }

    public function name(): string
    {
        return $this->header->name();
    }

    public function values(): Set
    {
        return $this->header->values();
    }

    public function toString(): string
    {
        return $this->header->toString();
    }
}
