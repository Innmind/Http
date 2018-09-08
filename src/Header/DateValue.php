<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\TimeContinuum\Format\Http;
use Innmind\TimeContinuum\{
    PointInTimeInterface,
    Timezone\Earth\UTC
};

final class DateValue extends Value\Value
{
    public function __construct(PointInTimeInterface $date)
    {
        parent::__construct($date->changeTimezone(new UTC)->format(new Http));
    }
}
