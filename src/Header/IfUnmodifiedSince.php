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
final class IfUnmodifiedSince implements Custom
{
    private function __construct(
        private Point $point,
    ) {
    }

    /**
     * @psalm-pure
     */
    public static function of(Point $point): self
    {
        return new self($point);
    }

    public function date(): Point
    {
        return $this->point;
    }

    #[\Override]
    public function normalize(): Header
    {
        return Header::of(
            'If-Unmodified-Since',
            Value::of(
                $this
                    ->point
                    ->changeOffset(Offset::utc())
                    ->format(Http::new()),
            ),
        );
    }
}
