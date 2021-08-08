<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\DomainException;
use Innmind\Immutable\Str;

/**
 * @psalm-immutable
 */
final class RangeValue implements Value
{
    private string $unit;
    private int $firstPosition;
    private int $lastPosition;

    public function __construct(
        string $unit,
        int $firstPosition,
        int $lastPosition
    ) {
        if (
            !Str::of($unit)->matches('~^\w+$~') ||
            $firstPosition < 0 ||
            $lastPosition < 0 ||
            $firstPosition > $lastPosition
        ) {
            throw new DomainException($unit);
        }

        $this->unit = $unit;
        $this->firstPosition = $firstPosition;
        $this->lastPosition = $lastPosition;
    }

    public function unit(): string
    {
        return $this->unit;
    }

    public function firstPosition(): int
    {
        return $this->firstPosition;
    }

    public function lastPosition(): int
    {
        return $this->lastPosition;
    }

    public function toString(): string
    {
        return \sprintf(
            '%s=%s-%s',
            $this->unit,
            $this->firstPosition,
            $this->lastPosition,
        );
    }
}
