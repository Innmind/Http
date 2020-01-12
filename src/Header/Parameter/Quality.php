<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\Parameter;

use Innmind\Http\Exception\DomainException;

final class Quality extends Parameter
{
    public function __construct(float $value)
    {
        if ($value < 0 || $value > 1) {
            throw new DomainException;
        }

        parent::__construct('q', (string) $value);
    }
}
