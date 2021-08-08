<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;

/**
 * @extends Header<RangeValue>
 * @implements HeaderInterface<RangeValue>
 * @psalm-immutable
 */
final class Range extends Header implements HeaderInterface
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
