<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\TimeContinuum\PointInTime;
use Innmind\Immutable\Set;

/**
 * @psalm-immutable
 */
final class LastModified implements HeaderInterface
{
    private Header $header;

    public function __construct(DateValue $date)
    {
        $this->header = new Header('Last-Modified', $date);
    }

    /**
     * @psalm-pure
     */
    public static function of(PointInTime $point): self
    {
        return new self(new DateValue($point));
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
