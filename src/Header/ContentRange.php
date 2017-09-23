<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

final class ContentRange extends Header
{
    public function __construct(ContentRangeValue $range)
    {
        parent::__construct('Content-Range', $range);
    }
}
