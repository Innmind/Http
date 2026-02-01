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
    /**
     * @param Sequence<Value> $values
     */
    private function __construct(
        private string $name,
        private Sequence $values,
    ) {
    }

    /**
     * @psalm-pure
     * @no-named-arguments
     */
    #[\NoDiscard]
    public static function of(string $name, Value ...$values): self
    {
        return new self($name, Sequence::of(...$values));
    }

    #[\NoDiscard]
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return Sequence<Value>
     */
    #[\NoDiscard]
    public function values(): Sequence
    {
        return $this->values;
    }

    #[\NoDiscard]
    public function toString(): string
    {
        $values = $this->values->map(static fn($value) => $value->toString());
        $values = Str::of(', ')->join($values);

        return $values->prepend("{$this->name}: ")->toString();
    }
}
