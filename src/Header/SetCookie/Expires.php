<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\SetCookie;

use Innmind\Http\{
    Header\Parameter,
    TimeContinuum\Format\Http,
};
use Innmind\TimeContinuum\{
    PointInTime,
    Offset,
};

/**
 * @psalm-immutable
 */
final class Expires
{
    private function __construct(
        private PointInTime $date,
    ) {
    }

    /**
     * @psalm-pure
     */
    public static function at(PointInTime $date): self
    {
        return new self($date->changeOffset(Offset::utc()));
    }

    public function date(): PointInTime
    {
        return $this->date;
    }

    public function toParameter(): Parameter
    {
        return Parameter::of(
            'Expires',
            $this->date->format(Http::new()),
        );
    }
}
