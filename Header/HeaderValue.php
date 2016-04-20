<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

final class HeaderValue implements HeaderValueInterface
{
    private $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
