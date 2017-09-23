<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\CacheControlValue;

use Innmind\Http\{
    Header\CacheControlValue,
    Exception\DomainException
};

final class MinimumFresh implements CacheControlValue
{
    private $age;

    public function __construct(int $age)
    {
        if ($age < 0) {
            throw new DomainException;
        }

        $this->age = $age;
    }

    public function age(): int
    {
        return $this->age;
    }

    public function __toString(): string
    {
        return sprintf(
            'min-fresh=%s',
            $this->age
        );
    }
}
