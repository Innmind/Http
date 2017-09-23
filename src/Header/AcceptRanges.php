<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

final class AcceptRanges extends Header
{
    public function __construct(AcceptRangesValue $ranges)
    {
        parent::__construct('Accept-Ranges', $ranges);
    }
}
