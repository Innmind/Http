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
    private Header $header;
    private AgeValue $value;

    public function __construct(AgeValue $age)
    {
        $this->header = new Header('Age', $age);
        $this->value = $age;
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
        return $this->header->name();
    }

    #[\Override]
    public function values(): Sequence
    {
        return $this->header->values();
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
        return $this->header->toString();
    }
}
