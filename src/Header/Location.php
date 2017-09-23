<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

final class Location extends Header
{
    public function __construct(LocationValue $location)
    {
        parent::__construct('Location', $location);
    }
}
