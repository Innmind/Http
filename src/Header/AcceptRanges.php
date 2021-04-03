<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;

/**
 * @extends Header<AcceptRangesValue>
 * @implements HeaderInterface<AcceptRangesValue>
 */
final class AcceptRanges extends Header implements HeaderInterface
{
    public function __construct(AcceptRangesValue $ranges)
    {
        parent::__construct('Accept-Ranges', $ranges);
    }

    public static function of(string $range): self
    {
        return new self(new AcceptRangesValue($range));
    }
}
