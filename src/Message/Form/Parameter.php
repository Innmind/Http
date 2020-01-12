<?php
declare(strict_types = 1);

namespace Innmind\Http\Message\Form;

use Innmind\Http\{
    Exception\DomainException
};

final class Parameter
{
    private string $name;
    private $value;

    public function __construct(string $name, $value)
    {
        if ($name === '') {
            throw new DomainException;
        }

        $this->name = $name;
        $this->value = $value;
    }

    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function value()
    {
        return $this->value;
    }
}
