<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\TimeContinuum\Format\Http;
use Innmind\TimeContinuum\{
    PointInTime,
    Earth\Timezone\UTC,
};

/**
 * @psalm-immutable
 */
final class DateValue implements Value
{
    private PointInTime $date;

    public function __construct(PointInTime $date)
    {
        $this->date = $date;
    }

    public function toString(): string
    {
        return $this->date->changeTimezone(new UTC)->format(new Http);
    }
}
