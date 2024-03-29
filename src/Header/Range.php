<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Immutable\Set;

/**
 * @psalm-immutable
 */
final class Range implements HeaderInterface
{
    private Header $header;
    private RangeValue $range;

    public function __construct(RangeValue $range)
    {
        $this->header = new Header('Range', $range);
        $this->range = $range;
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

    public function name(): string
    {
        return $this->header->name();
    }

    public function values(): Set
    {
        return $this->header->values();
    }

    public function range(): RangeValue
    {
        return $this->range;
    }

    public function toString(): string
    {
        return $this->header->toString();
    }
}
