<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\InvalidArgumentException;
use Innmind\Immutable\Str;

final class RangeValue extends HeaderValue\HeaderValue
{
    private $unit;
    private $firstPosition;
    private $lastPosition;

    public function __construct(
        string $unit,
        int $firstPosition,
        int $lastPosition
    ) {
        if (
            !(new Str($unit))->matches('~^\w+$~') ||
            $firstPosition < 0 ||
            $lastPosition < 0 ||
            $firstPosition > $lastPosition
        ) {
            throw new InvalidArgumentException;
        }

        $this->unit = $unit;
        $this->firstPosition = $firstPosition;
        $this->lastPosition = $lastPosition;
        parent::__construct(sprintf(
            '%s=%s-%s',
            $unit,
            $firstPosition,
            $lastPosition
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
