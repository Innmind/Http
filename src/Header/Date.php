<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\Http\Header as HeaderInterface;
use Innmind\TimeContinuum\PointInTime;

/**
 * @extends Header<DateValue>
 * @implements HeaderInterface<DateValue>
 */
final class Date extends Header implements HeaderInterface
{
    public function __construct(DateValue $date)
    {
        parent::__construct('Date', $date);
    }

    public static function of(PointInTime $point): self
    {
        return new self(new DateValue($point));
    }
}
