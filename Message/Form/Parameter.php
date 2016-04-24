<?php
declare(strict_types = 1);

namespace Innmind\Http\Message\Form;

final class Parameter implements ParameterInterface
{
    private $name;
    private $value;

    public function __construct(string $name, $value)
    {
        if ($name === '') {
            throw new InvalidArgumentException;
        }

        $this->name = $name;
        $this->value = $value;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function value()
    {
        return $this->value;
    }
}
