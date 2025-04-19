<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Immutable\Sequence;

/**
 * @psalm-immutable
 */
final class Age implements HeaderInterface
{
    public function __construct(
        private AgeValue $value,
    ) {
    }

    /**
     * @psalm-pure
     */
    public static function of(int $age): self
    {
        return new self(new AgeValue($age));
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
     * @return 0|positive-int
     */
    public function age(): int
    {
        return $this->value->age();
    }

    #[\Override]
    public function toString(): string
    {
        return $this->header()->toString();
    }

    private function header(): Header
    {
        return new Header('Age', $this->value);
    }
}
