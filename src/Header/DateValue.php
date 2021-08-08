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
final class DateValue extends Value\Value
{
    public function __construct(PointInTime $date)
    {
        parent::__construct($date->changeTimezone(new UTC)->format(new Http));
    }
}
