<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\InvalidArgumentException;
use Innmind\Immutable\StringPrimitive as Str;

final class ContentRangeValue extends HeaderValue
{
    private $unit;
    private $firstPosition;
    private $lastPosition;
    private $length;

    public function __construct(
        string $unit,
        int $firstPosition,
        int $lastPosition,
        int $length = null
    ) {
        if (
            !(new Str($unit))->match('~^\w+$~') ||
            $firstPosition < 0 ||
            $lastPosition < 0 ||
            ($length !== null && $length < 0) ||
            $firstPosition > $lastPosition ||
            ($length !== null && $lastPosition > $length)
        ) {
            throw new InvalidArgumentException;
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