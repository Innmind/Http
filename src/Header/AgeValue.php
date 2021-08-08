<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\DomainException;

/**
 * @psalm-immutable
 */
final class AgeValue implements Value
{
    private int $age;

    public function __construct(int $age)
    {
        if ($age < 0) {
            throw new DomainException((string) $age);
        }

        $this->age = $age;
    }

    public function toString(): string
    {
        return (string) $this->age;
    }
}
