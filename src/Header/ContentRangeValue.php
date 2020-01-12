<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\DomainException;
use Innmind\Immutable\Str;

final class ContentRangeValue extends Value\Value
{
    private string $unit;
    private int $firstPosition;
    private int $lastPosition;
    private ?int $length;

    public function __construct(
        string $unit,
        int $firstPosition,
        int $lastPosition,
        int $length = null
    ) {
        if (
            !Str::of($unit)->matches('~^\w+$~') ||
            $firstPosition < 0 ||
            $lastPosition < 0 ||
            ($length !== null && $length < 0) ||
            $firstPosition > $lastPosition ||
            ($length !== null && $lastPosition > $length)
        ) {
            throw new DomainException;
        }

        $this->unit = $unit;
        $this->firstPosition = $firstPosition;
        $this->lastPosition = $lastPosition;
        $this->length = $length;
        parent::__construct(sprintf(
            '%s %s-%s/%s',
            $unit,
            $firstPosition,
            $lastPosition,
            $length ?? '*'
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

    public function isLengthKnown(): bool
    {
        return $this->length !== null;
    }

    public function length(): int
    {
        return $this->length;
    }
}
