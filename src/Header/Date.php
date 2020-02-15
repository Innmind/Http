<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\TimeContinuum\PointInTime;

/**
 * @extends Header<DateValue>
 */
final class Date extends Header
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
