<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Immutable\Set;
use function Innmind\Immutable\join;

class Header implements HeaderInterface
{
    private string $name;
    private Set $values;

    public function __construct(string $name, Value ...$values)
    {
        $this->name = $name;
        $this->values = Set::of(Value::class, ...$values);
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
        $values = $this->values->mapTo(
            'string',
            fn(Value $value): string => $value->toString(),
        );
        $values = join(', ', $values);

        return $values->prepend("{$this->name}: ")->toString();
    }
}
