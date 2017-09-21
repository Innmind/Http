<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

interface HeaderValue
{
    public function __toString(): string;
}
