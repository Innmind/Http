<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

final class Expires extends Header
{
    public function __construct(DateValue $date)
    {
        parent::__construct('Expires', $date);
    }
}
