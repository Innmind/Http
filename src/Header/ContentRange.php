<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Immutable\Sequence;

/**
 * @psalm-immutable
 */
final class ContentRange implements HeaderInterface
{
    private Header $header;
    private ContentRangeValue $range;

    public function __construct(ContentRangeValue $range)
    {
        $this->header = new Header('Content-Range', $range);
        $this->range = $range;
    }

    /**
     * @psalm-pure
     */
    public static function of(
        string $unit,
        int $firstPosition,
        int $lastPosition,
        ?int $length = null,
    ): self {
        return new self(new ContentRangeValue(
            $unit,
            $firstPosition,
            $lastPosition,
            $length,
        ));
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

    public function range(): ContentRangeValue
    {
        return $this->range;
    }

    #[\Override]
    public function toString(): string
    {
        return $this->header->toString();
    }
}
