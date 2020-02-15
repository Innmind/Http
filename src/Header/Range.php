<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

/**
 * @extends Header<RangeValue>
 */
final class Range extends Header
{
    public function __construct(RangeValue $range)
    {
        parent::__construct('Range', $range);
    }

    public static function of(
        string $unit,
        int $firstPosition,
        int $lastPosition
    ): self {
        return new self(new RangeValue(
            $unit,
            $firstPosition,
            $lastPosition,
        ));
    }
}
