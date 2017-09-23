<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

final class Range extends Header
{
    public function __construct(RangeValue $range)
    {
        parent::__construct('Range', $range);
    }
}
