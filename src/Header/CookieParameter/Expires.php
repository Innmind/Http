<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\CookieParameter;

use Innmind\Http\{
    Header\Parameter\Parameter,
    TimeContinuum\Format\Http,
};
use Innmind\TimeContinuum\{
    PointInTime,
    Earth\Timezone\UTC,
};

/**
 * @psalm-immutable
 */
final class Expires extends Parameter
{
    public function __construct(PointInTime $date)
    {
        parent::__construct('Expires', $date->changeTimezone(new UTC)->format(new Http));
    }
}
