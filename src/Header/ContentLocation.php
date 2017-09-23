<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

final class ContentLocation extends Header
{
    public function __construct(LocationValue $location)
    {
        parent::__construct('Content-Location', $location);
    }
}
