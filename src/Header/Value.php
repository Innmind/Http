<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

/**
 * @psalm-immutable
 */
final class Value
{
    public function __construct(
        private string $value,
    ) {
    }

    public function toString(): string
    {
        return $this->value;
    }
}
