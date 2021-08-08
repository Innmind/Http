<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Immutable\Set;
use function Innmind\Immutable\join;

/**
 * @template A of Value
 * @implements HeaderInterface<A>
 * @psalm-immutable
 */
final class Header implements HeaderInterface
{
    private string $name;
    /** @var Set<A> */
    private Set $values;

    /**
     * @no-named-arguments
     * @param A $values
     */
    public function __construct(string $name, Value ...$values)
    {
        $this->name = $name;
        $this->values = Set::of(...$values);
    }

    public function name(): string
    {
        return $this->name;
    }

    public function values(): Set
    {
        return $this->values;
    }

    public function toString(): string
    {
        $values = $this->values->map(static fn($value) => $value->toString());
        $values = join(', ', $values);

        return $values->prepend("{$this->name}: ")->toString();
    }
}
