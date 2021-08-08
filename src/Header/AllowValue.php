<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Message\Method;

/**
 * @psalm-immutable
 */
final class AllowValue implements Value
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = Method::of($value)->toString();
    }

    public function toString(): string
    {
        return $this->value;
    }
}
