<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Immutable\Set;
use function Innmind\Immutable\unwrap;

class Header implements HeaderInterface
{
    private string $name;
    private Set $values;

    public function __construct(string $name, Value ...$values)
    {
        $this->name = $name;
        $this->values = array_reduce(
            $values,
            static function(Set $carry, Value $value): Set {
                return $carry->add($value);
            },
            Set::of(Value::class)
        );
    }

    public function name(): string
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function values(): Set
    {
        return $this->values;
    }

    public function toString(): string
    {
        $values = \array_map(
            fn(Value $value): string => $value->toString(),
            unwrap($this->values),
        );

        return \sprintf(
            '%s: %s',
            $this->name,
            \implode(', ', $values),
        );
    }
}
