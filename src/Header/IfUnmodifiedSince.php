<?php
declare(strict_types = 1);

namespace Innmind\Http\Header;

use Innmind\TimeContinuum\PointInTimeInterface;

final class IfUnmodifiedSince extends Header
{
    public function __construct(DateValue $date)
    {
        parent::__construct('If-Unmodified-Since', $date);
    }

    public static function of(PointInTimeInterface $point): self
    {
        return new self(new DateValue($point));
    }
}
