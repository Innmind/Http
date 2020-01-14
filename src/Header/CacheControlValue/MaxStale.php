<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\CacheControlValue;

use Innmind\Http\{
    Header\CacheControlValue,
    Exception\DomainException,
};

final class MaxStale implements CacheControlValue
{
    private int $age;

    public function __construct(int $age)
    {
        if ($age < 0) {
            throw new DomainException((string) $age);
        }

        $this->age = $age;
    }

    public function age(): int
    {
        return $this->age;
    }

    public function toString(): string
    {
        return \sprintf(
            'max-stale%s',
            $this->age > 0 ? '='.$this->age : '',
        );
    }
}
