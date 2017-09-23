<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

interface Value
{
    public function __toString(): string;
}
