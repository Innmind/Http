<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

final class Age extends Header
{
    public function __construct(AgeValue $age)
    {
        parent::__construct('Age', $age);
    }

    public static function of(int $age): self
    {
        return new self(new AgeValue($age));
    }
}
