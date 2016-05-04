<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

interface HeaderValueInterface
{
    public function __toString(): string;
}
