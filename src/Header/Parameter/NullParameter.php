<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\Parameter;

use Innmind\Http\Header\Parameter as ParameterInterface;

/**
 * @psalm-immutable
 */
final class NullParameter implements ParameterInterface
{
    #[\Override]
    public function name(): string
    {
        return '';
    }

    #[\Override]
    public function value(): string
    {
        return '';
    }

    #[\Override]
    public function toString(): string
    {
        return '';
    }
}
