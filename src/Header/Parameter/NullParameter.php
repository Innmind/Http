<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\Parameter;

use Innmind\Http\Header\Parameter as ParameterInterface;

/**
 * @psalm-immutable
 */
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

    public function toString(): string
    {
        return '';
    }
}
