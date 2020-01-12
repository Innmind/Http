<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\DomainException;
use Innmind\Immutable\Str;

final class RangeValue extends Value\Value
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
            throw new DomainException;
        }

        $this->unit = $unit;
        $this->firstPosition = $firstPosition;
        $this->lastPosition = $lastPosition;
        parent::__construct(\sprintf(
            '%s=%s-%s',
            $unit,
            $firstPosition,
            $lastPosition,
        ));
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
}
