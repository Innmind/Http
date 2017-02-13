<?php
declare(strict_types = 1);

namespace Innmind\Http\Factory;

use Innmind\Http\Header\HeaderInterface;
use Innmind\Immutable\Str;

interface HeaderFactoryInterface
{
    public function make(Str $name, Str $value): HeaderInterface;
}
