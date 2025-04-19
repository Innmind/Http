<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Immutable\Sequence;

/**
 * @psalm-immutable
 */
final class AcceptRanges implements HeaderInterface
{
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

    #[\Override]
    public function name(): string
    {
        return $this->header->name();
    }

    #[\Override]
    public function values(): Sequence
    {
        return $this->header->values();
    }

    #[\Override]
    public function toString(): string
    {
        return $this->header->toString();
    }
}
