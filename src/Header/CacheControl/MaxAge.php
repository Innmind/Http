<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\CacheControl;

/**
 * @psalm-immutable
 */
final class MaxAge
{
    /**
     * @param int<0, max> $age
     */
    private function __construct(
        private int $age,
    ) {
    }

    /**
     * @psalm-pure
     *
     * @param int<0, max> $age
     */
    public static function of(int $age): self
    {
        return new self($age);
    }

    /**
     * @return int<0, max>
     */
    public function age(): int
    {
        return $this->age;
    }

    public function toString(): string
    {
        return \sprintf(
            'max-age=%s',
            $this->age,
        );
    }
}
