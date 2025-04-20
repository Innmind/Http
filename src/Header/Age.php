<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header;
use Innmind\Immutable\Maybe;

/**
 * @psalm-immutable
 */
final class Age implements Custom
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
            $age >= 0 => new self($age),
            default => null,
        });
    }

    /**
     * @return int<0, max>
     */
    public function age(): int
    {
        return $this->age;
    }

    #[\Override]
    public function normalize(): Header
    {
        return new Header('Age', new Value((string) $this->age));
    }
}
