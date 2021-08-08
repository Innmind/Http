<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\Value;

use Innmind\Http\Header\Value as ValueInterface;

/**
 * @psalm-immutable
 */
class Value implements ValueInterface
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function toString(): string
    {
        return $this->value;
    }
}
