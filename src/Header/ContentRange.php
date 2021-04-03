<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;

/**
 * @extends Header<ContentRangeValue>
 * @implements HeaderInterface<ContentRangeValue>
 */
final class ContentRange extends Header implements HeaderInterface
{
    public function __construct(ContentRangeValue $range)
    {
        parent::__construct('Content-Range', $range);
    }

    public static function of(
        string $unit,
        int $firstPosition,
        int $lastPosition,
        int $length = null
    ): self {
        return new self(new ContentRangeValue(
            $unit,
            $firstPosition,
            $lastPosition,
            $length,
        ));
    }
}
