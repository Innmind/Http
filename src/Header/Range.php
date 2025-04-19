<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Immutable\Sequence;

/**
 * @psalm-immutable
 */
final class Range implements HeaderInterface
{
    public function __construct(
        private RangeValue $range,
    ) {
    }

    /**
     * @psalm-pure
     */
    public static function of(
        string $unit,
        int $firstPosition,
        int $lastPosition,
    ): self {
        return new self(new RangeValue(
            $unit,
            $firstPosition,
            $lastPosition,
        ));
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

    public function range(): RangeValue
    {
        return $this->range;
    }

    #[\Override]
    public function toString(): string
    {
        return $this->header()->toString();
    }

    private function header(): Header
    {
        return new Header('Range', $this->range);
    }
}
