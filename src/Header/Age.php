<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Immutable\Set;

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

    public function name(): string
    {
        return $this->header->name();
    }

    public function values(): Set
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

    public function toString(): string
    {
        return $this->header->toString();
    }
}
