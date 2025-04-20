<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\SetCookie;

use Innmind\Http\Header\Parameter;

/**
 * @psalm-immutable
 */
final class MaxAge
{
    /**
     * @param ?int<1, max> $age
     */
    private function __construct(
        private ?int $age,
    ) {
    }

    /**
     * @psalm-pure
     *
     * @param int<1, max> $age
     */
    public static function of(int $age): self
    {
        return new self($age);
    }

    /**
     * @psalm-pure
     */
    public static function expire(): self
    {
        return new self(null);
    }

    public function toInt(): int
    {
        return match ($this->age) {
            null => -1,
            default => $this->age,
        };
    }

    public function toParameter(): Parameter
    {
        return new Parameter('Max-Age', (string) $this->toInt());
    }
}
