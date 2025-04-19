<?php
declare(strict_types = 1);

namespace Innmind\Http;

use Innmind\Http\Header\Value;
use Innmind\Immutable\{
    Sequence,
    Str,
};

/**
 * @psalm-immutable
 */
final class Header
{
    private string $name;
    /** @var Sequence<Value> */
    private Sequence $values;

    /**
     * @no-named-arguments
     */
    public function __construct(string $name, Value ...$values)
    {
        $this->name = $name;
        $this->values = Sequence::of(...$values);
    }

    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return Sequence<Value>
     */
    public function values(): Sequence
    {
        return $this->values;
    }

    public function toString(): string
    {
        $values = $this->values->map(static fn($value) => $value->toString());
        $values = Str::of(', ')->join($values);

        return $values->prepend("{$this->name}: ")->toString();
    }
}
