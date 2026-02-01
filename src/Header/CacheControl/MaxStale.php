<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\CacheControl;

/**
 * @psalm-immutable
 */
final class MaxStale
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
    #[\NoDiscard]
    public static function of(int $age): self
    {
        return new self($age);
    }

    /**
     * @return int<0, max>
     */
    #[\NoDiscard]
    public function age(): int
    {
        return $this->age;
    }

    #[\NoDiscard]
    public function toString(): string
    {
        return \sprintf(
            'max-stale%s',
            $this->age > 0 ? '='.$this->age : '',
        );
    }
}
