<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory;

use Innmind\Http\Header;
use Innmind\Immutable\Str;

interface HeaderFactory
{
    public function __invoke(Str $name, Str $value): Header;
}
