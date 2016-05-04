<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

class Parameter implements ParameterInterface
{
    private $name;
    private $value;

    public function __construct(string $name, string $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return sprintf(
            '%s%s%s',
            $this->name,
            strlen($this->value) > 0 ? '=' : '',
            strlen($this->value) > 0 ? $this->value : ''
        );
    }
}
