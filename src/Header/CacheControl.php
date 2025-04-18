<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Immutable\Set;

/**
 * @psalm-immutable
 */
final class CacheControl implements HeaderInterface
{
    private Header $header;

    public function __construct(CacheControlValue $first, CacheControlValue ...$values)
    {
        $this->header = new Header('Cache-Control', $first, ...$values);
    }

    #[\Override]
    public function name(): string
    {
        return $this->header->name();
    }

    #[\Override]
    public function values(): Set
    {
        return $this->header->values();
    }

    #[\Override]
    public function toString(): string
    {
        return $this->header->toString();
    }
}
