<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

final class IfUnmodifiedSince extends Header
{
    public function __construct(DateValue $date)
    {
        parent::__construct('If-Unmodified-Since', $date);
    }
}
