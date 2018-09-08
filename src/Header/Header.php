<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Immutable\{
    SetInterface,
    Set
};

class Header implements HeaderInterface
{
    private $name;
    private $values;

    public function __construct(string $name, Value ...$values)
    {
        $this->name = $name;
        $this->values = array_reduce(
            $values,
            static function(Set $carry, Value $value): Set {
                return $carry->add($value);
            },
            new Set(Value::class)
        );
    }

    public function name(): string
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function values(): SetInterface
    {
        return $this->values;
    }

    public function __toString(): string
    {
        return sprintf(
            '%s: %s',
            $this->name,
            $this->values->join(', ')
        );
    }
}
