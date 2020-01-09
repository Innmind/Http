<?php
declare(strict_types = 1);

namespace Innmind\Http\Header\Value;

use Innmind\Http\Header\Value as ValueInterface;

class Value implements ValueInterface
{
    private $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function toString(): string
    {
        return $this->value;
    }
}
