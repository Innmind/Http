<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\{
    Header as HeaderInterface,
    TimeContinuum\Format\Http,
};
use Innmind\TimeContinuum\{
    PointInTime,
    Offset,
};
use Innmind\Immutable\Sequence;

/**
 * @psalm-immutable
 */
final class Date implements HeaderInterface
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

    #[\Override]
    public function name(): string
    {
        return $this->header()->name();
    }

    #[\Override]
    public function values(): Sequence
    {
        return $this->header()->values();
    }

    public function date(): PointInTime
    {
        return $this->point;
    }

    #[\Override]
    public function toString(): string
    {
        return $this->header()->toString();
    }

    private function header(): Header
    {
        return new Header(
            'Date',
            new Value\Value(
                $this
                    ->point
                    ->changeOffset(Offset::utc())
                    ->format(Http::new()),
            ),
        );
    }
}
