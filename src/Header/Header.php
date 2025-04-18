<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Immutable\{
    Set,
    Str,
};

/**
 * @psalm-immutable
 */
final class Header implements HeaderInterface
{
    private string $name;
    /** @var Set<Value> */
    private Set $values;

    /**
     * @no-named-arguments
     */
    public function __construct(string $name, Value ...$values)
    {
        $this->name = $name;
        $this->values = Set::of(...$values);
    }

    #[\Override]
    public function name(): string
    {
        return $this->name;
    }

    #[\Override]
    public function values(): Set
    {
        return $this->values;
    }

    #[\Override]
    public function toString(): string
    {
        $values = $this->values->map(static fn($value) => $value->toString());
        $values = Str::of(', ')->join($values);

        return $values->prepend("{$this->name}: ")->toString();
    }
}
