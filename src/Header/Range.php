<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Immutable\Set;

/**
 * @implements HeaderInterface<RangeValue>
 * @psalm-immutable
 */
final class Range implements HeaderInterface
{
    /** @var Header<RangeValue> */
    private Header $header;

    public function __construct(RangeValue $range)
    {
        $this->header = new Header('Range', $range);
    }

    /**
     * @psalm-pure
     */
    public static function of(
        string $unit,
        int $firstPosition,
        int $lastPosition
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

    public function toString(): string
    {
        return $this->header->toString();
    }
}
