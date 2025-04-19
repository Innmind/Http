<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\Value;

use Innmind\Http\Header\Value as ValueInterface;

/**
 * @psalm-immutable
 */
final class Value implements ValueInterface
{
    public function __construct(
        private string $value,
    ) {
    }

    #[\Override]
    public function toString(): string
    {
        return $this->value;
    }
}
