<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Immutable\{
    Sequence,
    Maybe,
};

/**
 * @psalm-immutable
 */
final class Age implements HeaderInterface
{
    /**
     * @param int<0, max> $age
     */
    private function __construct(
        private int $age,
    ) {
    }

    /**
     * @psalm-pure
     *
     * @param int<0, max> $age
     */
    public static function of(int $age): self
    {
        return new self($age);
    }

    /**
     * @psalm-pure
     *
     * @return Maybe<self>
     */
    public static function maybe(int $age): Maybe
    {
        return Maybe::of(match (true) {
            $age >= 0 => $age,
            default => null,
        })->map(static fn($age) => new self($age));
    }

    #[\Override]
    public function name(): string
    {
        return $this->header()->name();
    }

    #[\Override]
    public function values(): Sequence
    {
        return $this->header()->values();
    }

    /**
     * @return int<0, max>
     */
    public function age(): int
    {
        return $this->age;
    }

    #[\Override]
    public function toString(): string
    {
        return $this->header()->toString();
    }

    private function header(): Header
    {
        return new Header('Age', new Value\Value((string) $this->age));
    }
}
