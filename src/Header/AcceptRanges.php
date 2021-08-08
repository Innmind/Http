<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Immutable\Set;

/**
 * @implements HeaderInterface<AcceptRangesValue>
 * @psalm-immutable
 */
final class AcceptRanges implements HeaderInterface
{
    /** @var Header<AcceptRangesValue> */
    private Header $header;

    public function __construct(AcceptRangesValue $ranges)
    {
        $this->header = new Header('Accept-Ranges', $ranges);
    }

    /**
     * @psalm-pure
     */
    public static function of(string $range): self
    {
        return new self(new AcceptRangesValue($range));
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
