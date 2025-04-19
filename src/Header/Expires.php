<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\TimeContinuum\PointInTime;
use Innmind\Immutable\Sequence;

/**
 * @psalm-immutable
 */
final class Expires implements HeaderInterface
{
    private Header $header;
    private DateValue $value;

    public function __construct(DateValue $date)
    {
        $this->header = new Header('Expires', $date);
        $this->value = $date;
    }

    /**
     * @psalm-pure
     */
    public static function of(PointInTime $point): self
    {
        return new self(new DateValue($point));
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

    public function date(): PointInTime
    {
        return $this->value->date();
    }

    #[\Override]
    public function toString(): string
    {
        return $this->header->toString();
    }
}
