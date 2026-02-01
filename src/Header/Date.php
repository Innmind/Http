<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\{
    Header,
    Time\Format\Http,
};
use Innmind\Time\{
    Point,
    Offset,
};

/**
 * @psalm-immutable
 */
final class Date implements Custom
{
    private function __construct(
        private Point $point,
    ) {
    }

    /**
     * @psalm-pure
     */
    #[\NoDiscard]
    public static function of(Point $point): self
    {
        return new self($point);
    }

    #[\NoDiscard]
    public function date(): Point
    {
        return $this->point;
    }

    #[\Override]
    #[\NoDiscard]
    public function normalize(): Header
    {
        return Header::of(
            'Date',
            Value::of(
                $this
                    ->point
                    ->changeOffset(Offset::utc())
                    ->format(Http::new()),
            ),
        );
    }
}
