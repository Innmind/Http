<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Immutable\Set;

/**
 * @psalm-immutable
 */
final class ContentRange implements HeaderInterface
{
    private Header $header;

    public function __construct(ContentRangeValue $range)
    {
        $this->header = new Header('Content-Range', $range);
    }

    /**
     * @psalm-pure
     */
    public static function of(
        string $unit,
        int $firstPosition,
        int $lastPosition,
        int $length = null,
    ): self {
        return new self(new ContentRangeValue(
            $unit,
            $firstPosition,
            $lastPosition,
            $length,
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
