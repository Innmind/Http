<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\DomainException;
use Innmind\Immutable\Str;

/**
 * @psalm-immutable
 */
final class AcceptRangesValue implements Value
{
    private string $range;

    public function __construct(string $range)
    {
        if (!Str::of($range)->matches('~^\w+$~')) {
            throw new DomainException($range);
        }

        $this->range = $range;
    }

    public function toString(): string
    {
        return $this->range;
    }
}
