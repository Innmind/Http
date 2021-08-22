<?php
declare(strict_types = 1);

namespace Innmind\Http\Message\Form;

use Innmind\Http\Exception\DomainException;

/**
 * @psalm-immutable
 */
final class Parameter
{
    private string $name;
    private string|array $value;

    public function __construct(string $name, string|array $value)
    {
        if ($name === '') {
            throw new DomainException('Parameter name can\'t be empty');
        }

        $this->name = $name;
        $this->value = $value;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function value(): string|array
    {
        return $this->value;
    }
}
