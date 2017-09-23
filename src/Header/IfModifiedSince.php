<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

final class IfModifiedSince extends Header
{
    public function __construct(DateValue $date)
    {
        parent::__construct('If-Modified-Since', $date);
    }
}
