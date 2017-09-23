<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Exception\DomainException;

final class AgeValue extends Value\Value
{
    public function __construct(int $age)
    {
        if ($age < 0) {
            throw new DomainException;
        }

        parent::__construct((string) $age);
    }
}
