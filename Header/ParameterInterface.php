<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

interface ParameterInterface
{
    public function name(): string;
    public function value(): string;
    public function __toString(): string;
}
