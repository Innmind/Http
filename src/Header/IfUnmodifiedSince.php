<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\TimeContinuum\Format\Http;
use Innmind\TimeContinuum\{
    PointInTime,
    Offset,
};

/**
 * @psalm-immutable
 */
final class IfUnmodifiedSince implements Provider
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
    public function toHeader(): Header
    {
        return new Header(
            'If-Unmodified-Since',
            new Value\Value(
                $this
                    ->point
                    ->changeOffset(Offset::utc())
                    ->format(Http::new()),
            ),
        );
    }
}
