<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\{
    Header,
    TimeContinuum\Format\Http,
};
use Innmind\TimeContinuum\{
    PointInTime,
    Offset,
};

/**
 * @psalm-immutable
 */
final class IfModifiedSince implements Custom
{
    private function __construct(
        private PointInTime $point,
    ) {
    }

    /**
     * @psalm-pure
     */
    public static function of(PointInTime $point): self
    {
        return new self($point);
    }

    public function date(): PointInTime
    {
        return $this->point;
    }

    #[\Override]
    public function normalize(): Header
    {
        return Header::of(
            'If-Modified-Since',
            Value::of(
                $this
                    ->point
                    ->changeOffset(Offset::utc())
                    ->format(Http::new()),
            ),
        );
    }
}
