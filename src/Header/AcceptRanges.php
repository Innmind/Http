<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

/**
 * @extends Header<AcceptRangesValue>
 */
final class AcceptRanges extends Header
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
