<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\TimeContinuum\Format\Http;
use Innmind\TimeContinuum\{
    PointInTime,
    Offset,
};

/**
 * @psalm-immutable
 */
final class DateValue implements Value
{
    public function __construct(
        private PointInTime $date,
    ) {
    }

    public function date(): PointInTime
    {
        return $this->date;
    }

    #[\Override]
    public function toString(): string
    {
        return $this->date->changeOffset(Offset::utc())->format(Http::new());
    }
}
