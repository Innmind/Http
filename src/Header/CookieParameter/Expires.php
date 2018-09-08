<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\CookieParameter;

use Innmind\Http\{
    Header\Parameter\Parameter,
    TimeContinuum\Format\Http
};
use Innmind\TimeContinuum\{
    PointInTimeInterface,
    Timezone\Earth\UTC
};

final class Expires extends Parameter
{
    public function __construct(PointInTimeInterface $date)
    {
        parent::__construct('Expires', $date->changeTimezone(new UTC)->format(new Http));
    }
}
