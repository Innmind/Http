<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\CookieParameter;

use Innmind\Http\{
    Header\Parameter,
    TimeContinuum\Format\Http,
};
use Innmind\TimeContinuum\{
    PointInTime,
    Earth\Timezone\UTC,
};

/**
 * @psalm-immutable
 */
final class Expires implements Parameter
{
    private Parameter $parameter;

    public function __construct(PointInTime $date)
    {
        $this->parameter = new Parameter\Parameter(
            'Expires',
            $date->changeTimezone(new UTC)->format(new Http),
        );
    }

    public function name(): string
    {
        return $this->parameter->name();
    }

    public function value(): string
    {
        return $this->parameter->value();
    }

    public function toString(): string
    {
        return $this->parameter->toString();
    }
}
