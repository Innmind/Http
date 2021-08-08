<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\Immutable\Set;

/**
 * @implements HeaderInterface<AgeValue>
 * @psalm-immutable
 */
final class Age implements HeaderInterface
{
    /** @var Header<AgeValue> */
    private Header $header;

    public function __construct(AgeValue $age)
    {
        $this->header = new Header('Age', $age);
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

    public function toString(): string
    {
        return $this->header->toString();
    }
}
