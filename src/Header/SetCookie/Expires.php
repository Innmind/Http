<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\SetCookie;

use Innmind\Http\{
    Header\Parameter,
    Time\Format\Http,
};
use Innmind\Time\{
    Point,
    Offset,
};

/**
 * @psalm-immutable
 */
final class Expires
{
    private function __construct(
        private Point $date,
    ) {
    }

    /**
     * @psalm-pure
     */
    public static function at(Point $date): self
    {
        return new self($date->changeOffset(Offset::utc()));
    }

    public function date(): Point
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
