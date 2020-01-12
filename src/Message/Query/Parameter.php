<?php
declare(strict_types = 1);

namespace Innmind\Http\Message\Query;

use Innmind\Http\Exception\DomainException;

final class Parameter
{
    private string $name;
    private $value;

    public function __construct(string $name, $value)
    {
        if ($name === '') {
            throw new DomainException('Parameter name can\'t be empty');
        }

        if (!\is_string($value) && !\is_array($value)) {
            $given = \gettype($value);

            throw new \TypeError("Argument 2 must be of type string|array, $given given");
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
