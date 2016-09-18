<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

class NullParameter implements ParameterInterface
{
    public function name(): string
    {
        return '';
    }

    public function value(): string
    {
        return '';
    }

    public function __toString(): string
    {
        return '';
    }
}
