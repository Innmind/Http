<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\DomainException;
use Innmind\Immutable\{
    Str,
    Maybe,
};

/**
 * @psalm-immutable
 */
final class ContentRangeValue implements Value
{
    private string $unit;
    private int $firstPosition;
    private int $lastPosition;
    private ?int $length;

    public function __construct(
        string $unit,
        int $firstPosition,
        int $lastPosition,
        int $length = null,
    ) {
        if (
            !Str::of($unit)->matches('~^\w+$~') ||
            $firstPosition < 0 ||
            $lastPosition < 0 ||
            ($length !== null && $length < 0) ||
            $firstPosition > $lastPosition ||
            ($length !== null && $lastPosition > $length)
        ) {
            throw new DomainException($unit);
        }

        $this->unit = $unit;
        $this->firstPosition = $firstPosition;
        $this->lastPosition = $lastPosition;
        $this->length = $length;
    }

    /**
     * @psalm-pure
     *
     * @return Maybe<self>
     */
    public static function of(
        string $unit,
        int $firstPosition,
        int $lastPosition,
        int $length = null,
    ): Maybe {
        try {
            return Maybe::just(new self($unit, $firstPosition, $lastPosition, $length));
        } catch (DomainException $e) {
            /** @var Maybe<self> */
            return Maybe::nothing();
        }
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

    /**
     * @return Maybe<int>
     */
    public function length(): Maybe
    {
        return Maybe::of($this->length);
    }

    public function toString(): string
    {
        return \sprintf(
            '%s %s-%s/%s',
            $this->unit,
            $this->firstPosition,
            $this->lastPosition,
            $this->length ?? '*',
        );
    }
}
